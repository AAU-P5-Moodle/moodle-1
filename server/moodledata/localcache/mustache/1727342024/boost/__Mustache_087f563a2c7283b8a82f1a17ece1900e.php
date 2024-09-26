<?php

class __Mustache_087f563a2c7283b8a82f1a17ece1900e extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="page-context-header d-flex align-items-center mb-2">
';
        $value = $context->find('imagedata');
        $buffer .= $this->sectionA41a3ab0e23830c74c466bd19322371f($context, $indent, $value);
        $buffer .= $indent . '    <div class="page-header-headings">
';
        $value = $context->find('prefix');
        $buffer .= $this->sectionC1fa0385b839dbe9bdfef07a4f4a3fd7($context, $indent, $value);
        $buffer .= $indent . '        ';
        $value = $this->resolveValue($context->find('heading'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '    </div>
';
        $value = $context->find('hasadditionalbuttons');
        $buffer .= $this->sectionB28c7877b3cb8d9026c27357cece560e($context, $indent, $value);
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionA41a3ab0e23830c74c466bd19322371f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="page-header-image">
        {{{imagedata}}}
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="page-header-image">
';
                $buffer .= $indent . '        ';
                $value = $this->resolveValue($context->find('imagedata'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionC1fa0385b839dbe9bdfef07a4f4a3fd7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        <div class="text-muted text-uppercase small line-height-3">
            {{{prefix}}}
        </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '        <div class="text-muted text-uppercase small line-height-3">
';
                $buffer .= $indent . '            ';
                $value = $this->resolveValue($context->find('prefix'), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '
';
                $buffer .= $indent . '        </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFfa84c60ffaeca4e2848b955ec713562(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{name}}="{{value}}" ';
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
                $buffer .= '" ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section70275950d889f897d8443ef41210b8ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '{{formattedimage}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $this->resolveValue($context->find('formattedimage'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section02a130cf76503c039065e8ffb380269f(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
                    {{#pix}}{{formattedimage}}{{/pix}}
                    <span class="header-button-title">{{title}}</span>
                ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '                    ';
                $value = $context->find('pix');
                $buffer .= $this->section70275950d889f897d8443ef41210b8ca($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '                    <span class="header-button-title">';
                $value = $this->resolveValue($context->find('title'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '</span>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section947f64e0897b06a22795a5e3ef583d3d(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <a href="{{url}}" {{#attributes}} {{name}}="{{value}}" {{/attributes}}>
                {{#page}}
                    {{#pix}}{{formattedimage}}{{/pix}}
                    <span class="header-button-title">{{title}}</span>
                {{/page}}
                {{^page}}
                    <img src="{{formattedimage}}" alt="{{title}}">
                {{/page}}
            </a>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <a href="';
                $value = $this->resolveValue($context->find('url'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= '" ';
                $value = $context->find('attributes');
                $buffer .= $this->sectionFfa84c60ffaeca4e2848b955ec713562($context, $indent, $value);
                $buffer .= '>
';
                $value = $context->find('page');
                $buffer .= $this->section02a130cf76503c039065e8ffb380269f($context, $indent, $value);
                $value = $context->find('page');
                if (empty($value)) {
                    
                    $buffer .= $indent . '                    <img src="';
                    $value = $this->resolveValue($context->find('formattedimage'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '" alt="';
                    $value = $this->resolveValue($context->find('title'), $context);
                    $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                    $buffer .= '">
';
                }
                $buffer .= $indent . '            </a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionB28c7877b3cb8d9026c27357cece560e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
    <div class="btn-group header-button-group mx-3">
        {{#additionalbuttons}}
            <a href="{{url}}" {{#attributes}} {{name}}="{{value}}" {{/attributes}}>
                {{#page}}
                    {{#pix}}{{formattedimage}}{{/pix}}
                    <span class="header-button-title">{{title}}</span>
                {{/page}}
                {{^page}}
                    <img src="{{formattedimage}}" alt="{{title}}">
                {{/page}}
            </a>
        {{/additionalbuttons}}
    </div>
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '    <div class="btn-group header-button-group mx-3">
';
                $value = $context->find('additionalbuttons');
                $buffer .= $this->section947f64e0897b06a22795a5e3ef583d3d($context, $indent, $value);
                $buffer .= $indent . '    </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
