<?php

class __Mustache_707d070d32ae6415e94a403263513120 extends Mustache_Template
{
    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $buffer = '';

        $buffer .= $indent . '<div id="recentlyaccesseditems-view-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '     data-region="recentlyaccesseditems-view"
';
        $buffer .= $indent . '     data-noitemsimgurl="';
        $value = $this->resolveValue($context->find('noitemsimgurl'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    <div data-region="recentlyaccesseditems-view-content">
';
        $buffer .= $indent . '        <div data-region="recentlyaccesseditems-loading-placeholder">
';
        if ($partial = $this->mustache->loadPartial('block_recentlyaccesseditems/placeholder-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_recentlyaccesseditems/placeholder-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_recentlyaccesseditems/placeholder-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_recentlyaccesseditems/placeholder-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        if ($partial = $this->mustache->loadPartial('block_recentlyaccesseditems/placeholder-item')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </div>
';
        $buffer .= $indent . '    </div>
';
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '
';

        return $buffer;
    }
}
