<?php

class __Mustache_1a777db5c761632479f5777ca7d43050 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div class="h-100 d-flex flex-column">
';
        $buffer .= $indent . '    <div
';
        $buffer .= $indent . '        class="px-2 pb-2 pt-0 bg-light h-100"
';
        $buffer .= $indent . '        style="overflow-y: auto"
';
        $buffer .= $indent . '    >
';
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_day_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_day_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_day_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_day_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        if ($partial = $this->mustache->loadPartial('core_message/message_drawer_view_conversation_body_day_placeholder')) {
            $buffer .= $partial->renderInternal($context, $indent . '        ');
        }
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>';

        return $buffer;
    }
}
