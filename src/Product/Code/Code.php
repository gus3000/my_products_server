<?php

namespace App\Product\Code;

class Code
{
    private readonly string $code;

    public function __construct(
        string $code,
    ) {
        $this->code = str_replace('-', '', $code);
    }

    public function computeControlKey(): int
    {
        $numbers = array_map(fn (string $char) => (int) $char, str_split($this->code));

        $debugString = '';
        $sum = 0;
        for ($i = 0; $i < 12; ++$i) {
            if ($i % 2 === 0) {
                $sum += $numbers[$i];
                $debugString .= " $numbers[$i]";
            } else {
                $sum += 3 * $numbers[$i];
                $debugString .= ' '. 3 * $numbers[$i];
            }
        }

        //        dump($debugString);
        $remainder = $sum % 10;

        return 10 - $remainder;
    }

    public function isControlKeyValid(): bool
    {
        if (strlen($this->code) !== 13) {
            return false;
        }

        return intval($this->computeControlKey()) === intval($this->code[12]);
    }
}
