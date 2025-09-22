@extends('layouts.app')

@section('title', 'Mobile Menu Test')

@section('content')
<div class="container" style="padding: 50px 0;">
    <h1>Mobile Menu Test Page</h1>
    
    <div style="background: #f5f5f5; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2>Instructions:</h2>
        <ol>
            <li>Resize your browser window to less than 992px width (or use mobile device view in DevTools)</li>
            <li>Click the hamburger menu icon in the top right</li>
            <li>The mobile menu should slide in from the left</li>
            <li>Click on "Services" to expand the submenu</li>
            <li>All menu items should be clickable</li>
        </ol>
    </div>
    
    <div style="background: #e8f4f8; padding: 20px; border-radius: 5px; margin: 20px 0;">
        <h2>Test Status:</h2>
        <div id="test-status"></div>
    </div>
    
    <button onclick="runMobileMenuTest()" class="btn btn-primary" style="padding: 10px 20px; background: #ff6b35; border: none; color: white; border-radius: 5px; cursor: pointer;">
        Run Automated Test
    </button>
</div>

<script>
function runMobileMenuTest() {
    const statusDiv = document.getElementById('test-status');
    let results = [];
    
    // Test 1: Check jQuery
    if (typeof jQuery !== 'undefined') {
        results.push('✅ jQuery is loaded');
    } else {
        results.push('❌ jQuery is NOT loaded');
    }
    
    // Test 2: Check hamburger button
    const hamburger = document.querySelector('.bixol-mobile-hamburger');
    if (hamburger) {
        results.push('✅ Hamburger button found');
    } else {
        results.push('❌ Hamburger button NOT found');
    }
    
    // Test 3: Check mobile menu
    const mobileMenu = document.querySelector('.bixol-mobile-menu');
    if (mobileMenu) {
        results.push('✅ Mobile menu found');
        
        // Test 4: Check initial state
        const computedStyle = window.getComputedStyle(mobileMenu);
        const leftPosition = computedStyle.left;
        if (leftPosition === '-250px' || leftPosition === '-220px') {
            results.push('✅ Menu is initially hidden (left: ' + leftPosition + ')');
        } else {
            results.push('⚠️ Menu position: ' + leftPosition);
        }
    } else {
        results.push('❌ Mobile menu NOT found');
    }
    
    // Test 5: Check for submenu items
    const submenuItems = document.querySelectorAll('.bixol-mobile-menu .has-submenu');
    if (submenuItems.length > 0) {
        results.push('✅ Found ' + submenuItems.length + ' submenu items');
    } else {
        results.push('⚠️ No submenu items found');
    }
    
    // Test 6: Check main.js
    if (typeof Bixol !== 'undefined') {
        results.push('✅ Main.js is loaded (Bixol object exists)');
    } else {
        results.push('❌ Main.js may not be loaded properly');
    }
    
    // Test 7: Simulate click
    if (hamburger && mobileMenu && typeof jQuery !== 'undefined') {
        results.push('🔄 Testing menu toggle...');
        
        // Click to open
        jQuery(hamburger).click();
        
        setTimeout(() => {
            if (mobileMenu.classList.contains('mobile-menu-active')) {
                results.push('✅ Menu toggle works - menu is active');
                
                // Click to close
                jQuery(hamburger).click();
                
                setTimeout(() => {
                    if (!mobileMenu.classList.contains('mobile-menu-active')) {
                        results.push('✅ Menu closes properly');
                    } else {
                        results.push('⚠️ Menu did not close');
                    }
                    
                    // Display all results
                    statusDiv.innerHTML = results.join('<br>');
                }, 500);
            } else {
                results.push('❌ Menu did not open');
                statusDiv.innerHTML = results.join('<br>');
            }
        }, 500);
    } else {
        statusDiv.innerHTML = results.join('<br>');
    }
}

// Run test automatically on page load
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(runMobileMenuTest, 1000);
});
</script>
@endsection