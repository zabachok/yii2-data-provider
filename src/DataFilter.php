<?php

namespace zabachok\dataProvider;

use Yii;

abstract class DataFilter extends Filter implements IDataFilter
{
    /**
     * @param array $data
     * @return mixed
     */
    abstract protected function formatData(array $data);

    /**
     * DataFilter constructor.
     * @param array $form
     */
    public function __construct(array $form)
    {
        parent::__construct($form);
        if (empty($this->form['nextPage'])) {
            Yii::$app->cache->delete($this->getCacheKey());
        }
    }

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
            $this->getCacheTtl()
        );
    }

    /**
     * @return string
     */
    protected function getCacheKey(): string
    {
        $form = $this->filterForm($this->form);

        return md5($this->generateKey(
            'filter-key-{form}-{class}-{path}-{userId}',
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

    /**
     * @param string $pattern
     * @param array $data
     * @return string
     */
    private function generateKey(string $pattern, array $data): string
    {
        return str_replace(
            array_keys($data),
            array_values($data),
            $pattern
        );
    }

    /**
     * @return int
     */
    protected function getCacheTtl(): int
    {
        return 3600;
    }

    /**
     * @param array $form
     * @return array
     */
    protected function filterForm(array $form): array
    {
        unset($form['nextPage']);

        return $form;
    }
}