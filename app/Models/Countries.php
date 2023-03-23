<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Countries extends Model
{
    use HasFactory;

    protected $table      = 'countries';
    protected $primaryKey = 'id';
    protected $fillable   = [
        "name",
        "official_name",
        "native_name",
        "common_name",
        "acronym",
        "currency_name",
        "currency_symbol",
        "idd_root",
        "idd_suffixes",
        "capital",
        "region",
        "sub_region",
        "language",
        "timezone",
        "continents",
        "flags",
        "zip_code",
        "start_of_week",
    ];

    protected $casts = [
        "timezone" => "array",
        "flags"    => "array",
        "zip_code" => "array",
    ];

    /**
     * Importa os países do Json https://restcountries.com/v3.1/all
     */
    public static function importData()
    {

        $response = Http::get("https://restcountries.com/v3.1/all");
        $dados    = $response->json();

        /** Limpa a tabela para iniciar novo import */
        Countries::truncate();

        foreach ($dados as $dado) {

            $country = new Countries();

            $country->name          = self::checkIfTheKeyExists($dado, "name.common");
            $country->official_name = self::checkIfTheKeyExists($dado, "name.official");
            $country->acronym       = self::checkIfTheKeyExists($dado, "cca2");
            $country->idd_root      = self::checkIfTheKeyExists($dado, "idd.root");
            $country->idd_suffixes  = self::checkIfTheKeyExists($dado, "idd.suffixes.0");
            $country->capital       = self::checkIfTheKeyExists($dado, "capital.0");
            $country->region        = self::checkIfTheKeyExists($dado, "region");
            $country->sub_region    = self::checkIfTheKeyExists($dado, "subregion");
            $country->start_of_week = self::checkIfTheKeyExists($dado, "startOfWeek");
            $country->language      = json_encode(self::checkIfTheKeyExists($dado, "languages"));
            $country->timezone      = self::checkIfTheKeyExists($dado, "timezones");
            $country->continents    = json_encode(self::checkIfTheKeyExists($dado, "continents"));
            $country->flags         = self::checkIfTheKeyExists($dado, "flags");
            $country->zip_code      = self::checkIfTheKeyExists($dado, "postalCode");

            $country->save();
        }

        return response()->json(['message' => 'Dados importados com sucesso']);

    }

    /**
     * Valida se a chave existe no Json
     *
     * @param array $dados
     * @param string $chave
     */
    protected static function checkIfTheKeyExists($dados, $chave)
    {
        $valores = explode('.', $chave);
        $temp    = $dados;

        foreach ($valores as $valor) {
            if (!isset($temp[$valor])) {
                return null;
            }

            $temp = $temp[$valor];
        }

        return $temp;
    }
}
