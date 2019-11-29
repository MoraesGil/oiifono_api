<?php

namespace App\Rules;

use App\Entities\ProtocolQuestion;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;

class AppointmentEvolution implements Rule
{
    private $protocolId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($protocolId)
    {
        $this->protocolId = $protocolId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->protocolId == null) return true;
        return ProtocolQuestion::query()->where([
            'question_id' => $value['question_id'],
            'protocol_id' => $this->protocolId
        ])->whereHas('options', function (Builder $query) use ($value) {
            $query->where('option_id', $value['option_id']);
        })->get()->count() >= 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O par pergunta/opção não fazem parte do protocolo!';
    }
}
