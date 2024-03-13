<?php

//\Illuminate\Support\Facades\Schedule::command('market:fetch')->everyMinute();
\Illuminate\Support\Facades\Schedule::command('market:fetch')->everyOddHour();
