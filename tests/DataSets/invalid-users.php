<?php

use Illuminate\Http\Response;

dataset('invalid-users', [
    ['patient', Response::HTTP_FORBIDDEN],
    [null, Response::HTTP_UNAUTHORIZED],
]);
