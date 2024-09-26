<?php

class __Mustache_4495bfddf80f75aa91b670a0e7e1112a extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="card mb-1">
';
        $buffer .= $indent . '    <div class="card-body p-2 m-1">
';
        $buffer .= $indent . '        <div class="d-flex flex-row mw-100 align-items-center">
';
        $buffer .= $indent . '            <div class="bg-pulse-grey rounded-circle" style="height: 40px; width: 40px;"></div>
';
        $buffer .= $indent . '            <div class="ps-2" style="flex: 1;">
';
        $buffer .= $indent . '                <div class="bg-pulse-grey w-100" style="height: 1rem;"></div>
';
        $buffer .= $indent . '                <div class="bg-pulse-grey w-75 mt-1" style="height: 0.8rem;"></div>
';
        $buffer .= $indent . '            </div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }
}
