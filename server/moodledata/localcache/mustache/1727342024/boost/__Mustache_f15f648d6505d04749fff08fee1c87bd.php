<?php

class __Mustache_f15f648d6505d04749fff08fee1c87bd extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '
';
        $buffer .= $indent . '<div
';
        $buffer .= $indent . '    class="hidden"
';
        $buffer .= $indent . '    aria-hidden="true"
';
        $buffer .= $indent . '    data-region="view-group-info"
';
        $buffer .= $indent . '>
';
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="pt-3 h-100 d-flex flex-column"
';
        $buffer .= $indent . '        data-region="group-info-content-container"
';
        $buffer .= $indent . '        style="overflow-y: auto"
';
        $buffer .= $indent . '    ></div>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }
}
