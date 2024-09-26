<?php

class __Mustache_8ff10208621d8a3f783c4015458eb318 extends Mustache_Template
{
    private $lambdaHelper;

    public function renderInternal(Mustache_Context $context, $indent = '')
    {
        $this->lambdaHelper = new Mustache_LambdaHelper($this->mustache, $context);
        $buffer = '';

        if ($parent = $this->mustache->loadPartial('core/popover_region')) {
            $context->pushBlockContext(array(
                'classes' => array($this, 'block4100c75ced44c533f753c4400abe0aa9'),
                'attributes' => array($this, 'block3d72304decb3da6e7b281120f990fb90'),
                'togglelabel' => array($this, 'block33a7513e1e4284be3c840dfd161f9b69'),
                'togglecontent' => array($this, 'blockAd12693fb5178d1ff2148c69553d4237'),
                'containerlabel' => array($this, 'block29bd892fd1b26695973efaae9c6152aa'),
                'headertext' => array($this, 'blockC2e40aa45b830f9611a3094e97df8f74'),
                'headeractions' => array($this, 'block681a858abdd7df1b533d91750f5e9628'),
                'content' => array($this, 'blockAaf76660105c720a9d668885b7b85c3e'),
            ));
            $buffer .= $parent->renderInternal($context, $indent);
            $context->popBlockContext();
        }
        $value = $context->find('js');
        $buffer .= $this->section88065ecf8e995ae51a4c0135ea39dec2($context, $indent, $value);

        return $buffer;
    }

    private function sectionE9d311101fe112f08c4725ee17f65ad1(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' shownotificationwindownonew, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' shownotificationwindownonew, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section83c1c45b4b741aef24006ff87a6e04ce(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' shownotificationwindowwithcount, message, {{.}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' shownotificationwindowwithcount, message, ';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section8f0bc69b9ec68496ec93567882082edc(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' {{#str}} shownotificationwindowwithcount, message, {{.}} {{/str}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' ';
                $value = $context->find('str');
                $buffer .= $this->section83c1c45b4b741aef24006ff87a6e04ce($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section2c7f52d273f99ea528e3a7b6f56728eb(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' togglenotificationmenu, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' togglenotificationmenu, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5e5e0b34713d04b2df144144700c7e50(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/notifications, core, {{#str}} togglenotificationmenu, message {{/str}} ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/notifications, core, ';
                $value = $context->find('str');
                $buffer .= $this->section2c7f52d273f99ea528e3a7b6f56728eb($context, $indent, $value);
                $buffer .= ' ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionEb70af33b8011de7432c8334305b6a62(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' notificationwindow, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . ' notificationwindow, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section0485fa7464a648704afa92570f0944b7(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' notifications, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' notifications, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function sectionD52891bef9837f9da27028964220b7a5(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' markallread ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' markallread ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section256b33e22ff1d9e74ef049e25110e90a(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' t/markasread, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' t/markasread, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section5c109cc11ee011897152888aaf4973ba(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' notificationpreferences, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' notificationpreferences, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7680c9ab48e1615ec8d80b97eeaa59cd(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' i/settings, core ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' i/settings, core ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section06c12afb4bc898311d79a573e506c93e(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
            <a href="{{{ . }}}"
               title="{{#str}} notificationpreferences, message {{/str}}"
               aria-label="{{#str}} notificationpreferences, message {{/str}}">
                {{#pix}} i/settings, core {{/pix}}</a>
        ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . '            <a href="';
                $value = $this->resolveValue($context->last(), $context);
                $buffer .= ($value === null ? '' : $value);
                $buffer .= '"
';
                $buffer .= $indent . '               title="';
                $value = $context->find('str');
                $buffer .= $this->section5c109cc11ee011897152888aaf4973ba($context, $indent, $value);
                $buffer .= '"
';
                $buffer .= $indent . '               aria-label="';
                $value = $context->find('str');
                $buffer .= $this->section5c109cc11ee011897152888aaf4973ba($context, $indent, $value);
                $buffer .= '">
';
                $buffer .= $indent . '                ';
                $value = $context->find('pix');
                $buffer .= $this->section7680c9ab48e1615ec8d80b97eeaa59cd($context, $indent, $value);
                $buffer .= '</a>
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section7fd8a95ce9a614b8c5bab7e83009f0ca(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = ' nonotifications, message ';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= ' nonotifications, message ';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    private function section88065ecf8e995ae51a4c0135ea39dec2(Mustache_Context $context, $indent, $value)
    {
        $buffer = '';
    
        if (!is_string($value) && is_callable($value)) {
            $source = '
require([\'jquery\', \'message_popup/notification_popover_controller\'], function($, Controller) {
    var container = $(\'#nav-notification-popover-container\');
    var controller = new Controller(container);
    controller.registerEventListeners();
    controller.registerListNavigationEventListeners();
});
';
            $result = (string) call_user_func($value, $source, $this->lambdaHelper);
            $buffer .= $result;
        } elseif (!empty($value)) {
            $values = $this->isIterable($value) ? $value : array($value);
            foreach ($values as $value) {
                $context->push($value);
                
                $buffer .= $indent . 'require([\'jquery\', \'message_popup/notification_popover_controller\'], function($, Controller) {
';
                $buffer .= $indent . '    var container = $(\'#nav-notification-popover-container\');
';
                $buffer .= $indent . '    var controller = new Controller(container);
';
                $buffer .= $indent . '    controller.registerEventListeners();
';
                $buffer .= $indent . '    controller.registerListNavigationEventListeners();
';
                $buffer .= $indent . '});
';
                $context->pop();
            }
        }
    
        return $buffer;
    }

    public function block4100c75ced44c533f753c4400abe0aa9($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . 'popover-region-notifications';
    
        return $buffer;
    }

    public function block3d72304decb3da6e7b281120f990fb90($context)
    {
        $indent = $buffer = '';
        $buffer .= 'id="nav-notification-popover-container" data-userid="';
        $value = $this->resolveValue($context->find('userid'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '"';
    
        return $buffer;
    }

    public function block33a7513e1e4284be3c840dfd161f9b69($context)
    {
        $indent = $buffer = '';
        $value = $context->find('unreadcount');
        if (empty($value)) {
            
            $buffer .= ' ';
            $value = $context->find('str');
            $buffer .= $this->sectionE9d311101fe112f08c4725ee17f65ad1($context, $indent, $value);
            $buffer .= ' ';
        }
        $buffer .= ' ';
        $value = $context->find('unreadcount');
        $buffer .= $this->section8f0bc69b9ec68496ec93567882082edc($context, $indent, $value);
        $buffer .= ' ';
    
        return $buffer;
    }

    public function blockAd12693fb5178d1ff2148c69553d4237($context)
    {
        $indent = $buffer = '';
        $buffer .= '        ';
        $value = $context->find('pix');
        $buffer .= $this->section5e5e0b34713d04b2df144144700c7e50($context, $indent, $value);
        $buffer .= '
';
        $buffer .= $indent . '        <div
';
        $buffer .= $indent . '            class="count-container ';
        $value = $context->find('unreadcount');
        if (empty($value)) {
            
            $buffer .= 'hidden';
        }
        $buffer .= '"
';
        $buffer .= $indent . '            data-region="count-container"
';
        $buffer .= $indent . '            aria-hidden=true
';
        $buffer .= $indent . '        >
';
        $buffer .= $indent . '            ';
        $value = $this->resolveValue($context->find('unreadcount'), $context);
        $buffer .= ($value === null ? '' : call_user_func($this->mustache->getEscape(), $value));
        $buffer .= '
';
        $buffer .= $indent . '        </div>
';
    
        return $buffer;
    }

    public function block29bd892fd1b26695973efaae9c6152aa($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->sectionEb70af33b8011de7432c8334305b6a62($context, $indent, $value);
    
        return $buffer;
    }

    public function blockC2e40aa45b830f9611a3094e97df8f74($context)
    {
        $indent = $buffer = '';
        $value = $context->find('str');
        $buffer .= $this->section0485fa7464a648704afa92570f0944b7($context, $indent, $value);
    
        return $buffer;
    }

    public function block681a858abdd7df1b533d91750f5e9628($context)
    {
        $indent = $buffer = '';
        $buffer .= '        <a class="mark-all-read-button"
';
        $buffer .= $indent . '           href="#"
';
        $buffer .= $indent . '           title="';
        $value = $context->find('str');
        $buffer .= $this->sectionD52891bef9837f9da27028964220b7a5($context, $indent, $value);
        $buffer .= '"
';
        $buffer .= $indent . '           data-action="mark-all-read"
';
        $buffer .= $indent . '           role="button"
';
        $buffer .= $indent . '           aria-label="';
        $value = $context->find('str');
        $buffer .= $this->sectionD52891bef9837f9da27028964220b7a5($context, $indent, $value);
        $buffer .= '">
';
        $buffer .= $indent . '            <span class="normal-icon">';
        $value = $context->find('pix');
        $buffer .= $this->section256b33e22ff1d9e74ef049e25110e90a($context, $indent, $value);
        $buffer .= '</span>
';
        if ($partial = $this->mustache->loadPartial('core/loading')) {
            $buffer .= $partial->renderInternal($context, $indent . '            ');
        }
        $buffer .= $indent . '        </a>
';
        $value = $context->findDot('urls.preferences');
        $buffer .= $this->section06c12afb4bc898311d79a573e506c93e($context, $indent, $value);
    
        return $buffer;
    }

    public function blockAaf76660105c720a9d668885b7b85c3e($context)
    {
        $indent = $buffer = '';
        $buffer .= $indent . '        <div class="all-notifications"
';
        $buffer .= $indent . '            data-region="all-notifications"
';
        $buffer .= $indent . '            role="log"
';
        $buffer .= $indent . '            aria-busy="false"
';
        $buffer .= $indent . '            aria-atomic="false"
';
        $buffer .= $indent . '            aria-relevant="additions"></div>
';
        $buffer .= $indent . '        <div class="empty-message" tabindex="0" data-region="empty-message">';
        $value = $context->find('str');
        $buffer .= $this->section7fd8a95ce9a614b8c5bab7e83009f0ca($context, $indent, $value);
        $buffer .= '</div>
';
    
        return $buffer;
    }
}
