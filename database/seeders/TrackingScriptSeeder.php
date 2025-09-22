<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrackingScriptSeeder extends SafeSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $scripts = [
            [
                'name' => 'Google Analytics 4 - Example',
                'type' => 'ga4',
                'script_content' => '<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'G-XXXXXXXXXX\');
</script>',
                'position' => 'head',
                'is_active' => false, // Disabled by default - user needs to update with real ID
                'description' => 'Google Analytics 4 tracking script. Replace G-XXXXXXXXXX with your actual tracking ID.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Microsoft Clarity - Example',
                'type' => 'clarity',
                'script_content' => '<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "XXXXXXXXXX");
</script>',
                'position' => 'head',
                'is_active' => false, // Disabled by default - user needs to update with real ID
                'description' => 'Microsoft Clarity tracking script. Replace XXXXXXXXXX with your actual project ID.',
                'sort_order' => 20,
            ],
            [
                'name' => 'Google Tag Manager - Example',
                'type' => 'gtm',
                'script_content' => '<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-XXXXXXX\');</script>
<!-- End Google Tag Manager -->',
                'position' => 'head',
                'is_active' => false, // Disabled by default - user needs to update with real ID
                'description' => 'Google Tag Manager script for head section. Replace GTM-XXXXXXX with your actual container ID.',
                'sort_order' => 5,
            ],
            [
                'name' => 'Google Tag Manager (noscript) - Example',
                'type' => 'gtm',
                'script_content' => '<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-XXXXXXX"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->',
                'position' => 'body_start',
                'is_active' => false, // Disabled by default - user needs to update with real ID
                'description' => 'Google Tag Manager noscript fallback for body start. Replace GTM-XXXXXXX with your actual container ID.',
                'sort_order' => 5,
            ],
        ];

        foreach ($scripts as $script) {
            \App\Models\TrackingScript::create($script);
        }
    }
}
