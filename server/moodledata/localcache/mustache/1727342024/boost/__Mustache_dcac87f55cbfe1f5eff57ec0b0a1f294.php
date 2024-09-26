<?php

class __Mustache_dcac87f55cbfe1f5eff57ec0b0a1f294 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div id="course-format-';
        $value = $this->resolveValue($context->find('uniqid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '">
';
        $buffer .= $indent . '    <h2 class="accesshide">';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '</h2>
';
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('completionhelp'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    <ul class="';
        $value = $this->resolveValue($context->find('format'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '" data-for="course_sectionlist">
';
        $value = $context->find('initialsection');
        $buffer .= $this->section76385c5d8707a63ac5ca3f61d555f3ee($context, $indent, $value);
        $value = $context->find('sections');
        $buffer .= $this->section76385c5d8707a63ac5ca3f61d555f3ee($context, $indent, $value);
        $buffer .= $indent . '    </ul>
';
        $value = $context->find('hasnavigation');
        $buffer .= $this->sectionB2f7b467f78b89e74b74815dcd5482f3($context, $indent, $value);
        $value = $context->find('numsections');
        $buffer .= $this->section8e55219650f68c5d1035e3373d1eeb33($context, $indent, $value);
        $value = $context->find('bulkedittools');
        $buffer .= $this->section4670bbca37f3ea27af415ea8a377e2c8($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $value = $context->find('js');
        $buffer .= $this->section6f290f64c133181396964d965ba9c163($context, $indent, $value);

        return $buffer;
    }

    private function section76385c5d8707a63ac5ca3f61d555f3ee(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/section }}
                {{> core_courseformat/local/content/section }}
            {{/ core_courseformat/local/content/section }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section3556684102075bfdd0237c17dbb63a85(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/sectionnavigation }}
                {{> core_courseformat/local/content/sectionnavigation }}
            {{/ core_courseformat/local/content/sectionnavigation }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/sectionnavigation');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/sectionnavigation')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCff7c6dd1fb410fd7b6caae17c097d96(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/sectionselector }}
                {{> core_courseformat/local/content/sectionselector }}
            {{/ core_courseformat/local/content/sectionselector }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/sectionselector');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/sectionselector')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB2f7b467f78b89e74b74815dcd5482f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="single-section">
        {{#sectionnavigation}}
            {{$ core_courseformat/local/content/sectionnavigation }}
                {{> core_courseformat/local/content/sectionnavigation }}
            {{/ core_courseformat/local/content/sectionnavigation }}
        {{/sectionnavigation}}
        <ul class="{{format}}">
        {{#singlesection}}
            {{$ core_courseformat/local/content/section }}
                {{> core_courseformat/local/content/section }}
            {{/ core_courseformat/local/content/section }}
        {{/singlesection}}
        </ul>
        {{#sectionselector}}
            {{$ core_courseformat/local/content/sectionselector }}
                {{> core_courseformat/local/content/sectionselector }}
            {{/ core_courseformat/local/content/sectionselector }}
        {{/sectionselector}}
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="single-section">
';
                $value = $context->find('sectionnavigation');
                $buffer .= $this->section3556684102075bfdd0237c17dbb63a85($context, $indent, $value);
                $buffer .= $indent . '        <ul class="';
                $value = $this->resolveValue($context->find('format'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '">
';
                $value = $context->find('singlesection');
                $buffer .= $this->section76385c5d8707a63ac5ca3f61d555f3ee($context, $indent, $value);
                $buffer .= $indent . '        </ul>
';
                $value = $context->find('sectionselector');
                $buffer .= $this->sectionCff7c6dd1fb410fd7b6caae17c097d96($context, $indent, $value);
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8e55219650f68c5d1035e3373d1eeb33(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{^singlesection}}
            {{$ core_courseformat/local/content/addsection}}
                {{> core_courseformat/local/content/addsection}}
            {{/ core_courseformat/local/content/addsection}}
        {{/singlesection}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('singlesection');
                if (empty($value)) {
                    
                    $blockFunction = $context->findInBlock('core_courseformat/local/content/addsection');
                    if (is_callable($blockFunction)) {
                        $buffer .= call_user_func($blockFunction, $context);
                    } else {
                        if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/addsection')) {
                            $buffer .= $partial->renderInternal($context, $indent . '                ');
                        }
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section4670bbca37f3ea27af415ea8a377e2c8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/bulkedittools}}
            {{> core_courseformat/local/content/bulkedittools}}
        {{/ core_courseformat/local/content/bulkedittools}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/bulkedittools');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/bulkedittools')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section6f290f64c133181396964d965ba9c163(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'core_courseformat/local/content\'], function(component) {
    component.init(\'page\', {}, {{sectionreturn}});
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'core_courseformat/local/content\'], function(component) {
';
                $buffer .= $indent . '    component.init(\'page\', {}, ';
                $value = $this->resolveValue($context->find('sectionreturn'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ');
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
