<?php

namespace App\Http\Controllers;

use App\Model\Language;
use App\Model\EmailTemplate;
use App\Model\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Cache;

class LanguageController extends Controller
{
    public function index()
    {
        $data['menu']               = 'setting';
        $data['sub_menu']           = 'general';
        $data['list_menu']          = 'language';
        $data['languageList']          = Language::getAll();
        $data['languagesImgPath']   = 'public/uploads/flags';
        $data['languageShortName']  = getShortLanguageName(false, $data['languageList']);

        return view('admin.language.language_list', $data);
    }

    public function translation($id)
    {
        if (!is_writable(base_path('resources/lang/'))) {
            \Session::flash('fail', __('Need writable permission of language directory'));
            return back();
        }
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'general';
        $data['list_menu'] = 'language';
        $data['language'] = $language = Language::getAll()->where('id', $id)->first();
        if (empty($language)) {
            \Session::flash('fail', __('The data you are trying to access is not found.'));
            return redirect()->back();
        }
        updateLanguageFile($language->short_name);
        $data['jsonData'] = openJSONFile($language->short_name);

        return view('admin.language.translation', $data);
    }

    public function translationStore(Request $request)
    {
        if (!is_writable(base_path('resources/lang/'))) {
            \Session::flash('fail', __('Need writable permission of language directory'));
            return back();
        }
        $language = Language::getAll()->where('id', $request->id)->first();
        $data = openJSONFile($language->short_name);

        foreach ($request->key as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $secondKey => $secondValue) {
                    $data[$key][$secondKey] = $request->key[$key][$secondKey];
                }
            } else {
                $data[$key] = $request->key[$key];
            }
        }
        
        saveJSONFile($language->short_name, $data);
        \Session::flash('success', __('Successfully Updated'));
        return back();
    }

    public function delete_language(Request $request)
    {
        $data = [ 
                    'type'    => 'fail',
                    'message' => __('Something went wrong, please try again.')
                ];
        $shortName = Language::getAll()->where('id', $request->id)->first();
        if (!empty($shortName)) {
            $deletePermission = Preference::where([ 
                                                    'category' => 'company',
                                                    'field' => 'dflt_lang',
                                                    'value' => $shortName->short_name
                                            ])->count();
            if ($deletePermission == 1) {
                $data = [ 
                    'type'    => 'fail',
                    'message' => __('As default you can not delete')
                ];
            } else {
                // delete email template of the language
                EmailTemplate::where(['language_id' => $request->id])->delete();
                Cache::forget('gb-email_template');
                $lang = Language::where(['id' => $request->id])->delete();

                Cache::forget('gb-languages');
                $data = [ 
                   'type'    => 'success',
                    'message' => __('Deleted Successfully.')
                ];
            }
        }
        
        \Session::flash($data['type'], $data['message']);   
        return redirect()->back();
    }

    public function save_language(Request $request)
    {  
    	$this->validate($request, [
    		'language_name'    => 'required',
    		'status'        => 'required',
    		'direction'     => 'required'
    	]);
        
        if (!is_writable(base_path('resources/lang/'))) {
            \Session::flash('fail', __('Need writable permission of language directory'));
            return back();
        }

        $languages  = getShortLanguageName(true);
        if (!in_array(strtolower($request->language_name), array_keys($languages))) {
            \Session::flash('fail', __('Invalid Language'));   
        } else if (Language::where('short_name', $request->language_name)->exists()) {
            \Session::flash('fail', __('That language is already taken.'));   
        } else {
            $language             = new Language();
            $language->name       = $languages[strtolower($request->language_name)];
            $language->short_name = strtolower($request->language_name);
            $language->status     = $request->status;
            $language->direction  = $request->direction;
            $language->is_default = (isset($request->default) && $request->default === "on") ? 1 : 0;
            if (isset($request->default) && $request->default === "on") {
                $updateDefault = Language::where('is_default', 1)->update(['is_default' => 0]);
                $preferenceToUpdate = Preference::where('category', 'company')
                                        ->where('field', 'dflt_lang')
                                        ->update(['value' => $language->short_name]);
            }
            $language->save();
            Cache::forget('gb-languages');
            Cache::forget('gb-preferences');

            \Session::flash('success', __('Successfully Saved'));   
            return redirect('languages/translation/' . $language->id);
        }

        return redirect()->back();
    }

    public function edit(Request $request)
    {
        if (!empty($request->id)) {
            $language = Language::find($request->id);
            
            $return_lang['id'] = $language->id;
            $return_lang['language_name'] = $language->name;
            $return_lang['short_name'] = $language->short_name;
            $return_lang['flag'] = url("public/datta-able/fonts/flag/flags/4x3/". getSVGFlag($language->short_name) .".svg");
            $return_lang['status'] = $language->status;
            $return_lang['is_default'] = $language->is_default;
            $return_lang['direction'] = $language->direction;

            echo json_encode($return_lang);
        }
    }

    public function update_language(Request $request)
    {
        $this->validate($request, [
            'edit_status'        => 'required',
            'edit_direction'     => 'required',
        ]);

        $languages  = getShortLanguageName();

        $language             = Language::find($request->language_id);
        $language->status     = $request->edit_status;
        $language->direction  = $request->edit_direction;
        $language->is_default = (isset($request->edit_default) && $request->edit_default === "on") ? 1 : 0;
        if (isset($request->edit_default) && $request->edit_default === "on") {
                $updateDefault = Language::where('is_default', 1)->update(['is_default' => 0]);
                $preferenceToUpdate = Preference::where('category', 'company')
                                        ->where('field', 'dflt_lang')
                                        ->update(['value' => $language->short_name]);
        }
        $language->update();
        if ($language->update()) {
            if ($language->status == 'Active') {
                updateLanguageFile($language->short_name);
            }
        }
        Cache::forget('gb-languages');
        Cache::forget('gb-preferences');
        
        \Session::flash('success', __('Successfully updated'));   
        return redirect()->back();
    }

    public function validLanguageShortName()
    {
        if (isset($_GET['short_name'])) {
            $shortName= $_GET['short_name'];            
        } else {
            $shortName= $_GET['edit_short_name'];
        }
        if (isset($_GET['language_id'])) {
            $language_id = $_GET['language_id'];
            $v = DB::table('languages')
                ->where('short_name',$shortName)
                ->where('id', "!=", $language_id)
                ->first();
        } else {
            $v = DB::table('languages')
                ->where('short_name',$shortName)
                ->first();
        }             
              
        if (!empty($v)) {
            echo json_encode(__('That Short Name is already taken.'));
        } else {
            echo "true";
        }
    }
}
