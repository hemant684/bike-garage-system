<?php
/**
 * Toast Notification System
 * Bike Garage Management System
 * Version 2.0
 */

/**
 * Display toast notification
 */
function showToast() {
    if (!isset($_SESSION['toast'])) return;
    
    $toast = $_SESSION['toast'];
    unset($_SESSION['toast']);
    
    $type = $toast['type'] ?? 'info';
    $message = $toast['message'] ?? '';
    $title = $toast['title'] ?? '';
    
    $icons = [
        'success' => 'fa-check-circle',
        'error' => 'fa-times-circle',
        'warning' => 'fa-exclamation-triangle',
        'info' => 'fa-info-circle'
    ];
    
    $icon = $icons[$type] ?? 'fa-info-circle';
    
    echo "
    <div id='toast-{$type}' class='toast-container toast-{$type}'>
        <div class='toast-icon'>
            <i class='fas {$icon}'></i>
        </div>
        <div class='toast-content'>
            " . ($title ? "<div class='toast-title'>{$title}</div>" : "") . "
            <div class='toast-message'>{$message}</div>
        </div>
        <button class='toast-close' onclick='closeToast(this)'>
            <i class='fas fa-times'></i>
        </button>
        <div class='toast-progress'></div>
    </div>
    ";
}

/**
 * Set toast notification
 */
function setToast($type, $message, $title = '') {
    $_SESSION['toast'] = [
        'type' => $type,
        'message' => $message,
        'title' => $title
    ];
}

/**
 * Set success toast
 */
function toastSuccess($message, $title = 'Success!') {
    setToast('success', $message, $title);
}

/**
 * Set error toast
 */
function toastError($message, $title = 'Error!') {
    setToast('error', $message, $title);
}

/**
 * Set warning toast
 */
function toastWarning($message, $title = 'Warning!') {
    setToast('warning', $message, $title);
}

/**
 * Set info toast
 */
function toastInfo($message, $title = 'Info!') {
    setToast('info', $message, $title);
}

// Toast CSS styles
addAction('after_head', 'printToastStyles');
function printToastStyles() {
    echo "
    <style>
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            min-width: 320px;
            max-width: 400px;
            background: #1e1e1e;
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
            z-index: 9999;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.4s ease;
            border-left: 4px solid;
        }
        
        .toast-container.show {
            opacity: 1;
            transform: translateX(0);
        }
        
        .toast-container.toast-success {
            border-left-color: #2a9d8f;
        }
        
        .toast-container.toast-error {
            border-left-color: #e63946;
        }
        
        .toast-container.toast-warning {
            border-left-color: #f77f00;
        }
        
        .toast-container.toast-info {
            border-left-color: #00b4d8;
        }
        
        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .toast-success .toast-icon {
            background: rgba(42, 157, 143, 0.2);
            color: #2a9d8f;
        }
        
        .toast-error .toast-icon {
            background: rgba(230, 57, 70, 0.2);
            color: #e63946;
        }
        
        .toast-warning .toast-icon {
            background: rgba(247, 127, 0, 0.2);
            color: #f77f00;
        }
        
        .toast-info .toast-icon {
            background: rgba(0, 180, 216, 0.2);
            color: #00b4d8;
        }
        
        .toast-icon i {
            font-size: 1.2rem;
        }
        
        .toast-content {
            flex: 1;
        }
        
        .toast-title {
            font-weight: 600;
            color: #fff;
            margin-bottom: 4px;
        }
        
        .toast-message {
            color: #b0b0b0;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        
        .toast-close {
            background: none;
            border: none;
            color: #808080;
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
        }
        
        .toast-close:hover {
            color: #fff;
        }
        
        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }
        
        .toast-progress::after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            animation: toastProgress 5s linear forwards;
        }
        
        .toast-success .toast-progress::after {
            background: linear-gradient(90deg, transparent, #2a9d8f);
        }
        
        .toast-error .toast-progress::after {
            background: linear-gradient(90deg, transparent, #e63946);
        }
        
        .toast-warning .toast-progress::after {
            background: linear-gradient(90deg, transparent, #f77f00);
        }
        
        .toast-info .toast-progress::after {
            background: linear-gradient(90deg, transparent, #00b4d8);
        }
        
        @keyframes toastProgress {
            from { transform: translateX(-100%); }
            to { transform: translateX(0); }
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateX(0);
            }
            to {
                opacity: 0;
                transform: translateX(100%);
            }
        }
        
        .toast-container.show {
            animation: slideIn 0.4s ease forwards;
        }
        
        .toast-container.hiding {
            animation: slideOut 0.4s ease forwards;
        }
    </style>
    ";
}

// Toast JavaScript
addAction('after_scripts', 'printToastScripts');
function printToastScripts() {
    echo "
    <script>
        function closeToast(element) {
            const container = element.closest('.toast-container');
            container.classList.add('hiding');
            setTimeout(() => {
                container.remove();
            }, 400);
        }
        
        // Auto-show toast if exists in DOM
        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-container');
            toasts.forEach(toast => {
                setTimeout(() => {
                    toast.classList.add('show');
                }, 100);
            });
            
            // Auto-remove toast after 5 seconds
            setTimeout(() => {
                toasts.forEach(toast => {
                    if (!toast.classList.contains('hiding')) {
                        closeToast(toast.querySelector('.toast-close'));
                    }
                });
            }, 5000);
        });
        
        // Function to show toast from JavaScript
        function showToast(type, message, title = '') {
            const container = document.createElement('div');
            container.className = 'toast-container toast-' + type;
            container.innerHTML = getToastHTML(type, message, title);
            document.body.appendChild(container);
            
            setTimeout(() => {
                container.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                if (!container.classList.contains('hiding')) {
                    closeToast(container.querySelector('.toast-close'));
                }
            }, 5000);
        }
        
        function getToastHTML(type, message, title) {
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-times-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            
            return '<div class=\"toast-icon\"><i class=\"fas ' + icons[type] + '\"></i></div>' +
                   '<div class=\"toast-content\">' +
                   (title ? '<div class=\"toast-title\">' + title + '</div>' : '') +
                   '<div class=\"toast-message\">' + message + '</div></div>' +
                   '<button class=\"toast-close\" onclick=\"closeToast(this)\"><i class=\"fas fa-times\"></i></button>' +
                   '<div class=\"toast-progress\"></div>';
        }
    </script>
    ";
}

/**
 * Helper function to add action hooks
 */
function addAction($hook, $callback) {
    global $_actions;
    
    if (!isset($_actions[$hook])) {
        $_actions[$hook] = [];
    }
    
    $_actions[$hook][] = $callback;
}

/**
 * Execute action hooks
 */
function doAction($hook) {
    global $_actions;
    
    if (isset($_actions[$hook])) {
        foreach ($_actions[$hook] as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback);
            }
        }
    }
}

// Print styles and scripts if we're in a web context
if (php_sapi_name() !== 'cli') {
    ob_start();
    showToast();
    $toast = ob_get_clean();
}

