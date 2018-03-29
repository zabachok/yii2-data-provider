<?php

namespace app\filters;

use app\components\enums\KeysEnum;
use app\components\KeyGenerator;
use Yii;

abstract class DataFilter extends Filter implements IDataFilter
{
    use KeyGenerator;

    /**
     * @param array $data
     * @return mixed
     */
    abstract protected function formatData(array $data);

    /**
     * @param array $data
     * @return bool
     */
    public function saveData(array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        return Yii::$app->cache->set(
            $this->getCacheKey(),
            $this->formatData($data),
            Yii::$app->params['filter']['ttl']
        );
    }

    /**
     * @return string
     */
    protected function getCacheKey(): string
    {
        $form = $this->form;
        unset($form['nextPage']);

        return md5($this->generateKey(
            KeysEnum::FILTER_TTL,
            [
                '{form}' => serialize($form),
                '{class}' => static::class,
                '{path}' => Yii::$app->request->pathInfo,
                '{userId}' => Yii::$app->user->isGuest ? Yii::$app->session->id : Yii::$app->user->getId()
            ]
        ));
    }

    /**
     * @return mixed
     */
    protected function getDataFromCache()
    {
        return Yii::$app->cache->get($this->getCacheKey());
    }
}