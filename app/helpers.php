<?php

function transformedUrlAttachment($path)
{
    return $path ? asset('storage/'. $path) : null;
}