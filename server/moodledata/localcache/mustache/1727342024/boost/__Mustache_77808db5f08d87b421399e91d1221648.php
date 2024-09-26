<?php

class __Mustache_77808db5f08d87b421399e91d1221648 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<li class="list-group-item mt-3 p-0 px-2 border-0">
';
        $buffer .= $indent . '    <div class="w-50 bg-pulse-grey mt-1 mb-2" style="height: 20px"></div>
';
        $buffer .= $indent . '    <div>
';
        $buffer .= $indent . '        <ul class="ps-0 list-group list-group-flush">
';
        if ($partial = $this->mustache->loadPartial('block_timeline/placeholder-event-list-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_timeline/placeholder-event-list-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_timeline/placeholder-event-list-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_timeline/placeholder-event-list-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_timeline/placeholder-event-list-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </ul>
';
        $buffer .= $indent . '        <div class="pt-3 pb-2 d-flex justify-content-between">
';
        $buffer .= $indent . '            <div class="w-25 bg-pulse-grey" style="height: 35px"></div>
';
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</li>
';

        return $buffer;
    }
}
