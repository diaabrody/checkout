<?php


namespace App\Services\Weight;


use App\Repositories\Interfaces\IweightClassRepository;
use App\Services\BaseService;
use App\Services\Interfaces\IWeightClassService;

class WeightClassService extends BaseService implements IWeightClassService
{
    private $weights = [];

    public function load()
    {
        $weights = $this->repository->findAll();
        foreach ($weights as $weight) {
            $this->weights[$weight->unit] = [
                'id' => $weight->id,
                'title' => $weight->title,
                'unit' => $weight->unit,
                'value' => $weight->value
            ];
        }
        return $this;
    }

    /**
     * @param float $value
     * @param string $from
     * @param string $to
     * @return float
     */
    public function convert($value, $from, $to)
    {
        if ($from == $to) {
            return $value;
        }

        if (isset($this->weights[$from])) {
            $from = $this->weights[$from]['value'];
        } else {
            $from = 1;
        }

        if (isset($this->weights[$to])) {
            $to = $this->weights[$to]['value'];
        } else {
            $to = 1;
        }

        return $value * ($to / $from);
    }

    /**
     * @return string|null
     */
    public function repository()
    {
        return IweightClassRepository::class;
    }
}
