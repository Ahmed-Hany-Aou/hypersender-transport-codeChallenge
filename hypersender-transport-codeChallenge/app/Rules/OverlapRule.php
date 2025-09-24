<?php

namespace App\Rules;

use App\Models\Trip;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Carbon;

class OverlapRule implements ValidationRule
{
    private ?string $startTime;
    private ?string $endTime;
    private ?int $recordId;
    private string $foreignKey;
    private string $modelName;

    public function __construct(?string $startTime, ?string $endTime, string $foreignKey, string $modelName, ?int $recordId)
    {
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->foreignKey = $foreignKey;
        $this->modelName = $modelName;
        $this->recordId = $recordId;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (is_null($this->startTime) || is_null($this->endTime)) {
            return;
        }

        $startTime = Carbon::parse($this->startTime);
        $endTime = Carbon::parse($this->endTime);

        $query = Trip::where($this->foreignKey, $value)
            ->where('start_time', '<', $endTime)
            ->where('end_time', '>', $startTime);

        if ($this->recordId) {
            $query->where('id', '!=', $this->recordId);
        }

        if ($query->exists()) {
            $fail("The selected {$this->modelName} is already scheduled for an overlapping trip in the selected time range.");
        }
    }
}