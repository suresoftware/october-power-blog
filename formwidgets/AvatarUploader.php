<?php namespace SureSoftware\PowerBlog\FormWidgets;

use Backend\Classes\FormWidgetBase;

/**
 * AvatarUploader Form Widget
 */
class AvatarUploader extends FormWidgetBase
{
    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'suresoftware_powerblog_avatar_uploader';

    /**
     * @inheritDoc
     */
    public function init()
    {
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('avataruploader');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/avataruploader.css', 'SureSoftware.PowerBlog');
        $this->addJs('js/avataruploader.js', 'SureSoftware.PowerBlog');
    }

    protected function checkUploadPostback()
    {
        if (!post('X_BLOG_IMAGE_UPLOAD')) {
            return;
        }

        $uploadedFileName = null;

        try {
            $uploadedFile = Input::file('file');

            if ($uploadedFile) {
                $uploadedFileName = $uploadedFile->getClientOriginalName();
            }

            $validationRules = ['max:' . File::getMaxFilesize()];
            $validationRules[] = 'mimes:jpg,jpeg,bmp,png,gif';

            $validation = Validator::make(
                ['file_data' => $uploadedFile],
                ['file_data' => $validationRules]
            );

            if ($validation->fails()) {
                throw new ValidationException($validation);
            }

            if (!$uploadedFile->isValid()) {
                throw new SystemException(Lang::get('cms::lang.asset.file_not_valid'));
            }

            $fileRelation = $this->model->content_images();

            $file = new File();
            $file->data = $uploadedFile;
            $file->is_public = true;
            $file->save();

            $fileRelation->add($file, $this->sessionKey);
            $result = [
                'file' => $uploadedFileName,
                'path' => $file->getPath()
            ];

            $response = Response::make()->setContent($result);
            $response->send();

            die();
        } catch (\Exception $ex) {
            $message = $uploadedFileName
                ? Lang::get('cms::lang.asset.error_uploading_file',
                    ['name' => $uploadedFileName, 'error' => $ex->getMessage()])
                : $ex->getMessage();

            $result = [
                'error' => $message,
                'file' => $uploadedFileName
            ];

            $response = Response::make()->setContent($result);
            $response->send();

            die();
        }
    }

    /**
     * @inheritDoc
     */
    public function getSaveValue($value)
    {
        return $value;
    }
}
