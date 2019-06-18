<?php

public function scopeRecent($query)
{
    return $query->orderBy('id', 'desc');
}