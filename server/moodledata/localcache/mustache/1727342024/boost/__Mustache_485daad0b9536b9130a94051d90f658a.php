<?php

class __Mustache_485daad0b9536b9130a94051d90f658a extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $value = $context->find('showaddsection');
        $buffer .= $this->section161f31e3b0c6cc68fb95c629b0382c1d($context, $indent, $value);

        return $buffer;
    }

    private function section95103e0b0ba93f642b5a789ad318f6ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' data-id="{{id}}" ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' data-id="';
                $value = $this->resolveValue($context->find('id'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section09f26f1d124c8a1831c0b18f8203f1ba(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{title}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0aeeebab911fdf3aed4e4296aab8247e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'sectionaddmax, core_courseformat';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'sectionaddmax, core_courseformat';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9b089e00077ec061918a3e4dd2d05479(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/add, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/add, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section380af4db5adc3745b5605df8783c27ee(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    {{< core_courseformat/local/content/divider}}
        {{$extraclasses}}always-hidden mt-2{{/extraclasses}}
        {{$content}}
            <a href="{{{url}}}"
               class="btn add-content section-modchooser section-modchooser-link activitychooser-button d-flex justify-content-center align-items-center p-1 icon-no-margin
                    {{^canaddsection}}disabled{{/canaddsection}}"
                data-add-sections="{{title}}"
                data-new-sections="{{newsection}}"
                data-action="addSection"
                {{#insertafter}} data-id="{{id}}" {{/insertafter}}
                title="{{#canaddsection}}{{title}}{{/canaddsection}}{{^canaddsection}}{{#str}}sectionaddmax, core_courseformat{{/str}}{{/canaddsection}}"
            >
                {{#pix}} t/add, core {{/pix}}
            </a>
        {{/content}}
    {{/ core_courseformat/local/content/divider}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    ';
                if ($parent = $this->mustache->loadPartial('core_courseformat/local/content/divider')) {
                    $context->pushBlockContext(array(
                        'extraclasses' => array($this, 'block3af99b2d90b859d376606ea486417d9b'),
                        'content' => array($this, 'block58112185d4b64cb010c2a97bb7339865'),
                    ));
                    $buffer .= $parent->renderInternal($context, $indent);
                    $context->popBlockContext();
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section161f31e3b0c6cc68fb95c629b0382c1d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
<div class="changenumsections bulk-hidden {{^canaddsection}}disabled{{/canaddsection}}" data-region="section-addsection">
    {{#addsections}}
    {{< core_courseformat/local/content/divider}}
        {{$extraclasses}}always-hidden mt-2{{/extraclasses}}
        {{$content}}
            <a href="{{{url}}}"
               class="btn add-content section-modchooser section-modchooser-link activitychooser-button d-flex justify-content-center align-items-center p-1 icon-no-margin
                    {{^canaddsection}}disabled{{/canaddsection}}"
                data-add-sections="{{title}}"
                data-new-sections="{{newsection}}"
                data-action="addSection"
                {{#insertafter}} data-id="{{id}}" {{/insertafter}}
                title="{{#canaddsection}}{{title}}{{/canaddsection}}{{^canaddsection}}{{#str}}sectionaddmax, core_courseformat{{/str}}{{/canaddsection}}"
            >
                {{#pix}} t/add, core {{/pix}}
            </a>
        {{/content}}
    {{/ core_courseformat/local/content/divider}}
    {{/addsections}}
</div>
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '<div class="changenumsections bulk-hidden ';
                $value = $context->find('canaddsection');
                if (empty($value)) {
                    
                    $buffer .= 'disabled';
                }
                $buffer .= '" data-region="section-addsection">
';
                $value = $context->find('addsections');
                $buffer .= $this->section380af4db5adc3745b5605df8783c27ee($context, $indent, $value);
                $buffer .= $indent . '</div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block3af99b2d90b859d376606ea486417d9b($context)
    {
        $indent = $buffer = '';
        $buffer .= 'always-hidden mt-2';
    
        return $buffer;
    }

    public function block58112185d4b64cb010c2a97bb7339865($context)
    {
        $indent = $buffer = '';
        $buffer .= '            <a href="';
        $value = $this->resolveValue($context->find('url'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '"
';
        $buffer .= $indent . '               class="btn add-content section-modchooser section-modchooser-link activitychooser-button d-flex justify-content-center align-items-center p-1 icon-no-margin
';
        $buffer .= $indent . '                    ';
        $value = $context->find('canaddsection');
        if (empty($value)) {
            
            $buffer .= 'disabled';
        }
        $buffer .= '"
';
        $buffer .= $indent . '                data-add-sections="';
        $value = $this->resolveValue($context->find('title'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                data-new-sections="';
        $value = $this->resolveValue($context->find('newsection'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '                data-action="addSection"
';
        $buffer .= $indent . '                ';
        $value = $context->find('insertafter');
        $buffer .= $this->section95103e0b0ba93f642b5a789ad318f6ca($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '                title="';
        $value = $context->find('canaddsection');
        $buffer .= $this->section09f26f1d124c8a1831c0b18f8203f1ba($context, $indent, $value);
        $value = $context->find('canaddsection');
        if (empty($value)) {
            
            $value = $context->find('str');
            $buffer .= $this->section0aeeebab911fdf3aed4e4296aab8247e($context, $indent, $value);
        }
        $buffer .= '"
';
        $buffer .= $indent . '            >
';
        $buffer .= $indent . '                ';
        $value = $context->find('pix');
        $buffer .= $this->section9b089e00077ec061918a3e4dd2d05479($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '            </a>
';
    
        return $buffer;
    }
}
