<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdjustableDetailLevelResource extends JsonResource
{
    const DETAIL_MINIMAL = 'DETAIL_MINIMAL';

    const DETAIL_ALL = 'DETAIL_ALL';

    /**
     * @var string
     */
    protected $detailLevel = self::DETAIL_MINIMAL;

    /**
     * AdjustableDetailsLevelResource constructor.
     *
     * @param $resource
     * @param null $detailLevel
     * @return void
     */
    public function __construct($resource, $detailLevel = null)
    {
        parent::__construct($resource);
        if (! is_null($detailLevel)) {
            $this->detailLevel = $detailLevel;
        }
    }

    /**
     * Adjust show detail level.
     *
     * @param string $level
     * @return $this
     */
    public function showDetail(string $level): self
    {
        $this->detailLevel = $level;

        return $this;
    }
}
