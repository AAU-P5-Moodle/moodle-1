<?php

class __Mustache_b874fea7a0da86ffc9a613e4e5726aa3 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        $buffer .= $indent . '<div class="course-section-header d-flex"
';
        $buffer .= $indent . '     data-for="section_title"
';
        $buffer .= $indent . '     data-id="';
        $value = $this->resolveValue($context->find('id'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '     data-number="';
        $value = $this->resolveValue($context->find('num'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '>
';
        $value = $context->find('singleheader');
        $buffer .= $this->sectionF514aa2796a2f1948f6ba1a7d7b41f47($context, $indent, $value);
        $value = $context->find('header');
        $buffer .= $this->sectionF514aa2796a2f1948f6ba1a7d7b41f47($context, $indent, $value);
        $value = $context->find('singleheader');
        if (empty($value)) {
            
            $value = $context->find('restrictionlock');
            $buffer .= $this->sectionEab2db63044a2551ae58533d342b37e2($context, $indent, $value);
        }
        $buffer .= $indent . '    <div data-region="sectionbadges" class="sectionbadges d-flex align-items-center">
';
        $blockFunction = $context->findInBlock('core_courseformat/local/content/section/badges');
        if (is_callable($blockFunction)) {
            $buffer .= call_user_func($blockFunction, $context);
        } else {
            if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/badges')) {
                $buffer .= $partial->renderInternal($context, $indent . '            ');
            }
        }
        $buffer .= $indent . '    </div>
';
        $value = $context->find('collapsemenu');
        $buffer .= $this->sectionFfdc749d5f665359a2290d0f8c6ca347($context, $indent, $value);
        $value = $context->find('controlmenu');
        $buffer .= $this->sectionCa5b1428acecd39600ee4f957e3da9f3($context, $indent, $value);
        $value = $context->find('header');
        $buffer .= $this->section39c00f405b8fc88dc3f98595e0ae1105($context, $indent, $value);
        $buffer .= $indent . '</div>
';
        $buffer .= $indent . '<div id="coursecontentcollapse';
        $value = $this->resolveValue($context->find('num'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"
';
        $buffer .= $indent . '     class="content ';
        $value = $context->find('iscoursedisplaymultipage');
        if (empty($value)) {
            
            $value = $context->find('sitehome');
            if (empty($value)) {
                
                $value = $context->find('displayonesection');
                if (empty($value)) {
                    
                    $buffer .= 'course-content-item-content collapse ';
                    $value = $context->find('contentcollapsed');
                    if (empty($value)) {
                        
                        $buffer .= 'show';
                    }
                }
            }
        }
        $buffer .= '">
';
        $buffer .= $indent . '    <div class="';
        $value = $context->find('hasavailability');
        $buffer .= $this->section1dee8adaf405bfc6db6cbb048fef1653($context, $indent, $value);
        $buffer .= ' my-3" data-for="sectioninfo">
';
        $value = $context->find('summary');
        $buffer .= $this->sectionF9fe7b16c3f2f42e028ee69a07a76d0b($context, $indent, $value);
        $value = $context->find('availability');
        $buffer .= $this->section65440092f5becab85b22e8ba2b7fc0c7($context, $indent, $value);
        $buffer .= $indent . '    </div>
';
        $value = $context->find('cmsummary');
        $buffer .= $this->sectionDd2a1ba3c922d2310931ea6325e1658e($context, $indent, $value);
        $value = $context->find('cmlist');
        $buffer .= $this->sectionFf6d6f976062008ddcf7cc6a919fc5d8($context, $indent, $value);
        $buffer .= $indent . '    ';
        $value = $this->resolveValue($context->find('cmcontrols'), $context);
        $buffer .= ($value === null ? '' : $value);
        $buffer .= '
';
        $buffer .= $indent . '</div>
';

        return $buffer;
    }

    private function sectionF514aa2796a2f1948f6ba1a7d7b41f47(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/section/header }}
            {{> core_courseformat/local/content/section/header }}
        {{/ core_courseformat/local/content/section/header }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section/header');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/header')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0b7a74ef365e2e19e174c81d3ebda570(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/unlock, core';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/unlock, core';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEab2db63044a2551ae58533d342b37e2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <div class="align-self-center ms-2">
                {{#pix}}t/unlock, core{{/pix}}
            </div>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <div class="align-self-center ms-2">
';
                $buffer .= $indent . '                ';
                $value = $context->find('pix');
                $buffer .= $this->section0b7a74ef365e2e19e174c81d3ebda570($context, $indent, $value);
                $buffer .= '
';
                $buffer .= $indent . '            </div>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionE1c5833858b6a763436e852c524f170c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'collapseall';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'collapseall';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5c42c2ba118f2e9924725a2f71fafad6(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'expandall';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'expandall';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFfdc749d5f665359a2290d0f8c6ca347(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{^displayonesection}}
            <div class="flex-fill d-flex justify-content-end me-2 align-self-start mt-2">
                <a id="collapsesections"
                   class="section-collapsemenu"
                   href="#"
                   aria-expanded="true"
                   role="button"
                   data-toggle="toggleall"
                >
                    <span class="collapseall text-nowrap">{{#str}}collapseall{{/str}}</span>
                    <span class="expandall text-nowrap">{{#str}}expandall{{/str}}</span>
                </a>
            </div>
        {{/displayonesection}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('displayonesection');
                if (empty($value)) {
                    
                    $buffer .= $indent . '            <div class="flex-fill d-flex justify-content-end me-2 align-self-start mt-2">
';
                    $buffer .= $indent . '                <a id="collapsesections"
';
                    $buffer .= $indent . '                   class="section-collapsemenu"
';
                    $buffer .= $indent . '                   href="#"
';
                    $buffer .= $indent . '                   aria-expanded="true"
';
                    $buffer .= $indent . '                   role="button"
';
                    $buffer .= $indent . '                   data-toggle="toggleall"
';
                    $buffer .= $indent . '                >
';
                    $buffer .= $indent . '                    <span class="collapseall text-nowrap">';
                    $value = $context->find('str');
                    $buffer .= $this->sectionE1c5833858b6a763436e852c524f170c($context, $indent, $value);
                    $buffer .= '</span>
';
                    $buffer .= $indent . '                    <span class="expandall text-nowrap">';
                    $value = $context->find('str');
                    $buffer .= $this->section5c42c2ba118f2e9924725a2f71fafad6($context, $indent, $value);
                    $buffer .= '</span>
';
                    $buffer .= $indent . '                </a>
';
                    $buffer .= $indent . '            </div>
';
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionCa5b1428acecd39600ee4f957e3da9f3(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{^displayonesection}}
            {{$ core_courseformat/local/content/section/controlmenu }}
                {{> core_courseformat/local/content/section/controlmenu }}
            {{/ core_courseformat/local/content/section/controlmenu }}
        {{/displayonesection}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('displayonesection');
                if (empty($value)) {
                    
                    $blockFunction = $context->findInBlock('core_courseformat/local/content/section/controlmenu');
                    if (is_callable($blockFunction)) {
                        $buffer .= call_user_func($blockFunction, $context);
                    } else {
                        if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/controlmenu')) {
                            $buffer .= $partial->renderInternal($context, $indent . '                ');
                        }
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section70fc2265f21857283760f122a5c52abf(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'gotosection, course, {{name}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'gotosection, course, ';
                $value = $this->resolveValue($context->find('name'), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section9ea6be45f1588d6476c3f4a2d3f1e926(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/right, moodle';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/right, moodle';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8115b5e8e6b9abaabc1687cbdb72c01c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 't/left, moodle, {{#str}}gotosection, course, {{name}}{{/str}}';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 't/left, moodle, ';
                $value = $context->find('str');
                $buffer .= $this->section70fc2265f21857283760f122a5c52abf($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section26775455b6b03666ba4728e048c8f62c(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{^displayonesection}}
                {{^controlmenu}}
                    <div class="section_goto bulk-hidden ms-auto" data-sectionid="{{id}}">
                        <a href="{{{url}}}"
                           class="btn btn-icon d-flex align-items-center justify-content-center icon-no-margin"
                           title="{{#str}}gotosection, course, {{name}}{{/str}}">
                            <span class="dir-rtl-hide">
                                {{#pix}}t/right, moodle{{/pix}}
                            </span>
                            <span class="dir-ltr-hide">
                                {{#pix}}t/left, moodle, {{#str}}gotosection, course, {{name}}{{/str}}{{/pix}}
                            </span>
                            <span class="sr-only">
                                {{#str}}gotosection, course, {{name}}{{/str}}
                            </span>
                        </a>
                    </div>
                {{/controlmenu}}
            {{/displayonesection}}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('displayonesection');
                if (empty($value)) {
                    
                    $value = $context->find('controlmenu');
                    if (empty($value)) {
                        
                        $buffer .= $indent . '                    <div class="section_goto bulk-hidden ms-auto" data-sectionid="';
                        $value = $this->resolveValue($context->find('id'), $context);
                        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                        $buffer .= '">
';
                        $buffer .= $indent . '                        <a href="';
                        $value = $this->resolveValue($context->find('url'), $context);
                        $buffer .= ($value === null ? '' : $value);
                        $buffer .= '"
';
                        $buffer .= $indent . '                           class="btn btn-icon d-flex align-items-center justify-content-center icon-no-margin"
';
                        $buffer .= $indent . '                           title="';
                        $value = $context->find('str');
                        $buffer .= $this->section70fc2265f21857283760f122a5c52abf($context, $indent, $value);
                        $buffer .= '">
';
                        $buffer .= $indent . '                            <span class="dir-rtl-hide">
';
                        $buffer .= $indent . '                                ';
                        $value = $context->find('pix');
                        $buffer .= $this->section9ea6be45f1588d6476c3f4a2d3f1e926($context, $indent, $value);
                        $buffer .= '
';
                        $buffer .= $indent . '                            </span>
';
                        $buffer .= $indent . '                            <span class="dir-ltr-hide">
';
                        $buffer .= $indent . '                                ';
                        $value = $context->find('pix');
                        $buffer .= $this->section8115b5e8e6b9abaabc1687cbdb72c01c($context, $indent, $value);
                        $buffer .= '
';
                        $buffer .= $indent . '                            </span>
';
                        $buffer .= $indent . '                            <span class="sr-only">
';
                        $buffer .= $indent . '                                ';
                        $value = $context->find('str');
                        $buffer .= $this->section70fc2265f21857283760f122a5c52abf($context, $indent, $value);
                        $buffer .= '
';
                        $buffer .= $indent . '                            </span>
';
                        $buffer .= $indent . '                        </a>
';
                        $buffer .= $indent . '                    </div>
';
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section39c00f405b8fc88dc3f98595e0ae1105(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{#headerdisplaymultipage}}
            {{^displayonesection}}
                {{^controlmenu}}
                    <div class="section_goto bulk-hidden ms-auto" data-sectionid="{{id}}">
                        <a href="{{{url}}}"
                           class="btn btn-icon d-flex align-items-center justify-content-center icon-no-margin"
                           title="{{#str}}gotosection, course, {{name}}{{/str}}">
                            <span class="dir-rtl-hide">
                                {{#pix}}t/right, moodle{{/pix}}
                            </span>
                            <span class="dir-ltr-hide">
                                {{#pix}}t/left, moodle, {{#str}}gotosection, course, {{name}}{{/str}}{{/pix}}
                            </span>
                            <span class="sr-only">
                                {{#str}}gotosection, course, {{name}}{{/str}}
                            </span>
                        </a>
                    </div>
                {{/controlmenu}}
            {{/displayonesection}}
        {{/headerdisplaymultipage}}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $value = $context->find('headerdisplaymultipage');
                $buffer .= $this->section26775455b6b03666ba4728e048c8f62c($context, $indent, $value);
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section1dee8adaf405bfc6db6cbb048fef1653(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = 'description';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= 'description';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionF9fe7b16c3f2f42e028ee69a07a76d0b(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/section/summary }}
                {{> core_courseformat/local/content/section/summary }}
            {{/ core_courseformat/local/content/section/summary }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section/summary');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/summary')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section65440092f5becab85b22e8ba2b7fc0c7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            {{$ core_courseformat/local/content/section/availability }}
                {{> core_courseformat/local/content/section/availability }}
            {{/ core_courseformat/local/content/section/availability }}
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section/availability');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/availability')) {
                        $buffer .= $partial->renderInternal($context, $indent . '                ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionDd2a1ba3c922d2310931ea6325e1658e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/section/cmsummary }}
            {{> core_courseformat/local/content/section/cmsummary }}
        {{/ core_courseformat/local/content/section/cmsummary }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section/cmsummary');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/cmsummary')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionFf6d6f976062008ddcf7cc6a919fc5d8(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
        {{$ core_courseformat/local/content/section/cmlist }}
            {{> core_courseformat/local/content/section/cmlist }}
        {{/ core_courseformat/local/content/section/cmlist }}
    ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $blockFunction = $context->findInBlock('core_courseformat/local/content/section/cmlist');
                if (is_callable($blockFunction)) {
                    $buffer .= call_user_func($blockFunction, $context);
                } else {
                    if ($partial = $this->mustache->loadPartial('core_courseformat/local/content/section/cmlist')) {
                        $buffer .= $partial->renderInternal($context, $indent . '            ');
                    }
                }
                $context->pop();
            }
        }
    
        return $buffer;
    }

}
