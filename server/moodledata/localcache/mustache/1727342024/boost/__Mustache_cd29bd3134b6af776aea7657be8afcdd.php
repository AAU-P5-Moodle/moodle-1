<?php

class __Mustache_cd29bd3134b6af776aea7657be8afcdd extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="dropdown';
        $value = $context->findDot('secondary.items');
        if (empty($value)) {
            
            $buffer .= ' hidden';
        }
        $buffer .= '">
';
        $buffer .= $indent . '    <a
';
        $buffer .= $indent . '        href="#"
';
        $buffer .= $indent . '        tabindex="0"
';
        $buffer .= $indent . '        class="';
        $value = $this->resolveValue($context->find('triggerextraclasses'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= ' dropdown-toggle icon-no-margin"
';
        $buffer .= $indent . '        id="action-menu-toggle-';
        $value = $this->resolveValue($context->find('instance'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        aria-label="';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        data-toggle="dropdown"
';
        $buffer .= $indent . '        role="';
        $value = $this->resolveValue($context->find('triggerrole'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '        aria-haspopup="true"
';
        $buffer .= $indent . '        aria-expanded="false"
';
        $buffer .= $indent . '        aria-controls="action-menu-';
        $value = $this->resolveValue($context->find('instance'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '-menu"
';
        $value = $context->find('triggerattributes');
        $buffer .= $this->section8985cb674e88b5dac8453258ae010d93($context, $indent, $value);
        $buffer .= $indent . '    >
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('actiontext'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('menutrigger'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $value = $context->find('icon');
        $buffer .= $this->section15e4211117119fe9bc0d928b214dbd1b($context, $indent, $value);
        $buffer .= $indent . '            ';
        $value = $context->find('rawicon');
        $buffer .= $this->sectionFb8e8ddc9ca3702110812af7d06781d6($context, $indent, $value);
        $buffer .= '
';
        $value = $context->find('menutrigger');
        $buffer .= $this->section89ae097a4603ecfa470370d34daf2f10($context, $indent, $value);
        $buffer .= $indent . '    </a>
';
        $value = $context->find('secondary');
        $buffer .= $this->section2e8784a0faf141fd05ec703d76277803($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function section8985cb674e88b5dac8453258ae010d93(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{name}}="{{value}}"
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section405505afc7f0960b491968ffe7f7ec4d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{key}},{{component}},{{title}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    ';
                $value = $this->resolveValue($context->find('key'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ',';
                $value = $this->resolveValue($context->find('component'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ',';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section15e4211117119fe9bc0d928b214dbd1b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#pix}}
                    {{key}},{{component}},{{title}}
                {{/pix}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('pix');
                $buffer .= $this->section405505afc7f0960b491968ffe7f7ec4d($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFb8e8ddc9ca3702110812af7d06781d6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{{.}}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section89ae097a4603ecfa470370d34daf2f10(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <b class="caret"></b>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <b class="caret"></b>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionAd20463c348991d5bbd2fb97358ea7c0(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{name}}="{{value}}"';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '="';
                $value = $this->resolveValue($context->find('value'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section78028136b30ee159a393bc3446ba3d4c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{< core/action_menu_link}}
                        {{$actionmenulinkclasses}}dropdown-item {{classes}}{{/actionmenulinkclasses}}
                    {{/ core/action_menu_link}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    ';
                if ($parent = $this->mustache->loadPartial('core/action_menu_link')) {
                    $context->pushBlockContext(array(
                        'actionmenulinkclasses' => array($this, 'block496426400859c1321da08e3f01888592'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3f72e9958bde892e0dc4988229d2aacc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <div class="dropdown-divider" role="presentation"><span class="filler">&nbsp;</span></div>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= '                    <div class="dropdown-divider" role="presentation"><span class="filler">&nbsp;</span></div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4e3b43df7ac8f8b8b35df483bab78577(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{> core/local/action_menu/subpanel}}
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                if ($partial = $this->mustache->loadPartial('core/local/action_menu/subpanel')) {
                    $buffer .= $partial->renderInternal($context, $indent . '                    ');
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section68f8e66e4928b3ecbf4036d72863588d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    <div class="dropdown-item">{{> core/action_menu_item }}</div>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    <div class="dropdown-item">';
                if ($partial = $this->mustache->loadPartial('core/action_menu_item')) {
                    $buffer .= $partial->renderInternal($context);
                }
                $buffer .= '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4738e3e6b496c496fef86c880c5ce7a8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                {{#actionmenulink}}
                    {{< core/action_menu_link}}
                        {{$actionmenulinkclasses}}dropdown-item {{classes}}{{/actionmenulinkclasses}}
                    {{/ core/action_menu_link}}
                {{/actionmenulink}}
                {{#actionmenufiller}}
                    <div class="dropdown-divider" role="presentation"><span class="filler">&nbsp;</span></div>
                {{/actionmenufiller}}
                {{#subpanel}}
                    {{> core/local/action_menu/subpanel}}
                {{/subpanel}}
                {{#simpleitem}}
                    <div class="dropdown-item">{{> core/action_menu_item }}</div>
                {{/simpleitem}}
            ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('actionmenulink');
                $buffer .= $this->section78028136b30ee159a393bc3446ba3d4c($context, $indent, $value);
                $value = $context->find('actionmenufiller');
                $buffer .= $this->section3f72e9958bde892e0dc4988229d2aacc($context, $indent, $value);
                $value = $context->find('subpanel');
                $buffer .= $this->section4e3b43df7ac8f8b8b35df483bab78577($context, $indent, $value);
                $value = $context->find('simpleitem');
                $buffer .= $this->section68f8e66e4928b3ecbf4036d72863588d($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2e8784a0faf141fd05ec703d76277803(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="dropdown-menu {{classes}} {{dropdownalignment}}"{{#attributes}} {{name}}="{{value}}"{{/attributes}}>
            {{#items}}
                {{#actionmenulink}}
                    {{< core/action_menu_link}}
                        {{$actionmenulinkclasses}}dropdown-item {{classes}}{{/actionmenulinkclasses}}
                    {{/ core/action_menu_link}}
                {{/actionmenulink}}
                {{#actionmenufiller}}
                    <div class="dropdown-divider" role="presentation"><span class="filler">&nbsp;</span></div>
                {{/actionmenufiller}}
                {{#subpanel}}
                    {{> core/local/action_menu/subpanel}}
                {{/subpanel}}
                {{#simpleitem}}
                    <div class="dropdown-item">{{> core/action_menu_item }}</div>
                {{/simpleitem}}
            {{/items}}
        </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="dropdown-menu ';
                $value = $this->resolveValue($context->find('classes'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $value = $this->resolveValue($context->find('dropdownalignment'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '"';
                $value = $context->find('attributes');
                $buffer .= $this->sectionAd20463c348991d5bbd2fb97358ea7c0($context, $indent, $value);
                $buffer .= '>
';
                $value = $context->find('items');
                $buffer .= $this->section4738e3e6b496c496fef86c880c5ce7a8($context, $indent, $value);
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block496426400859c1321da08e3f01888592($context)
    {
        $indent = $buffer = '';
        $buffer .= 'dropdown-item ';
        $value = $this->resolveValue($context->find('classes'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
    
        return $buffer;
    }
}
