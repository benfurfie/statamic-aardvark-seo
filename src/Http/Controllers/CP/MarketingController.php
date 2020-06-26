<?php

namespace WithCandour\AardvarkSeo\Http\Controllers\CP;

use Statamic\CP\Breadcrumbs;
use WithCandour\AardvarkSeo\Http\Controllers\CP\Interfaces\Publishable;
use WithCandour\AardvarkSeo\Blueprints\CP\MarketingSettingsBlueprint;
use WithCandour\AardvarkSeo\Facades\AardvarkStorage;

class MarketingController extends Controller implements Publishable
{
    public function index()
    {
        $data = $this->getData();

        $blueprint = $this->getBlueprint();
        $fields = $blueprint->fields()->addValues($data)->preProcess();

        $crumbs = Breadcrumbs::make([
            ['text' => 'Aardvark SEO', 'url' => '/cp/aardvark-seo/settings'],
            ['text' => 'Marketing Settings', 'url' => '/marketing'],
        ]);

        return view('aardvark-seo::cp.settings.marketing', [
            'blueprint' => $blueprint->toPublishArray(),
            'crumbs' => $crumbs,
            'meta' => $fields->meta(),
            'title' => 'Marketing Settings | Aardvark SEO',
            'values' => $fields->values(),
        ]);
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $blueprint = $this->getBlueprint();

        $fields = $blueprint->fields()->addValues($request->all());
        $fields->validate();

        $this->putData($fields->process()->values()->toArray());
    }

    /**
     * @inheritdoc
     */
    public function getBlueprint()
    {
        return MarketingSettingsBlueprint::requestBlueprint();
    }

    /**
     * @inheritdoc
     */
    public function getData()
    {
        return AardvarkStorage::getYaml('marketing');
    }

    /**
     * @inheritdoc
     */
    public function putData($data)
    {
        return AardvarkStorage::putYaml('marketing', $data);
    }
}