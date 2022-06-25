<?php

namespace App\Models;

use App\Enums\FieldType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use voku\helper\ASCII;

class Field extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type'];

    protected $appends = ['value'];

    public static function createFields($fields_to_create): array {

        $created_fields = [];
        foreach ($fields_to_create as $item) {

            $field = Field::create($item)->only('id','title','type');
            $field['value'] = $item['value'];

            $created_fields[] = $field;
        }

        return $created_fields;
    }

    public function getValueAttribute() {

        if ($this->pivot && $this->pivot->value !== null) {
            return $this->castType($this->type, $this->pivot->value);
        }

        return null;
    }

    private function castType($type, $val) {

        switch ($type) {
            case FieldType::Date->value:
                $val = Carbon::parse($val)->format('Y-m-d');
                break;
            case FieldType::Number->value:
                settype($val, "integer");
                break;
            default:
                settype($val, $type);
                break;
        }


        return $val;
    }
}
