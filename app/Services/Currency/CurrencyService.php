<?php


namespace App\Services\Currency;


use App\Repositories\EloquentImpl\Currency\CurrencyRepository;
use App\Repositories\Interfaces\ICurrencyRepository;
use App\Services\BaseService;
use App\Services\Interfaces\ICurrencyService;

class CurrencyService extends BaseService implements ICurrencyService
{
    private $currencies = [];

    public function load()
    {
        $currencies = $this->repository->findAll();
        foreach ($currencies as $currency) {
            $this->currencies[$currency->code] = [
                'currency_id' => $currency->id,
                'title' => $currency->title,
                'symbol' => $currency->symbol,
                'value' => $currency->value
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
        if (isset($this->currencies[$from])) {
            $from = $this->currencies[$from]['value'];
        } else {
            $from = 1;
        }

        if (isset($this->currencies[$to])) {
            $to = $this->currencies[$to]['value'];
        } else {
            $to = 1;
        }

        return $value * ($to / $from);
    }

    /**
     * @param string $currency
     * @return string
     */
    public function getSymbol($currency)
    {
        if (isset($this->currencies[$currency])) {
            return $this->currencies[$currency]['symbol'];
        } else {
            return '';
        }
    }

    public function repository()
    {
        return ICurrencyRepository::class;
    }


}
