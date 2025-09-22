<?php

return [
    'encoding' => 'UTF-8',
    'finalize' => true,
    'ignoreNonStrings' => false,
    'cachePath' => storage_path('app/purifier'),
    'cacheFileMode' => 0755,
    
    'settings' => [
        // Default configuration for general content
        'default' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'div,b,strong,i,em,u,a[href|title|target],ul,ol,li,p[style],br,span[style],img[width|height|alt|src],h1,h2,h3,h4,h5,h6,blockquote,table,thead,tbody,tr,td[colspan|rowspan],th[colspan|rowspan]',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align,margin,margin-left,margin-right,margin-top,margin-bottom',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => true,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
            'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            'HTML.MaxImgLength' => null,
            'CSS.MaxImgLength' => null,
            'HTML.FlashAllowFullScreen' => false,
            'HTML.SafeObject' => false,
            'HTML.SafeEmbed' => false,
            'URI.AllowedSchemes' => ['http', 'https', 'mailto', 'tel'],
            'URI.DisableExternalResources' => false,
            'Output.TidyFormat' => false,
        ],
        
        // Strict configuration for user-generated content
        'strict' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'p,br,strong,em,u,a[href|title],ul,ol,li,blockquote',
            'CSS.AllowedProperties' => '',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => true,
            'HTML.SafeIframe' => false,
            'URI.AllowedSchemes' => ['http', 'https'],
            'Attr.AllowedFrameTargets' => ['_blank'],
            'URI.DisableExternalResources' => true,
        ],
        
        // Admin configuration - allows more HTML elements
        'admin' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'div[class|id|style],b,strong,i,em,u,a[href|title|target|class],ul[class|style],ol[class|style],li[class|style],p[style|class],br,span[style|class],img[width|height|alt|src|class],h1[class|id],h2[class|id],h3[class|id],h4[class|id],h5[class|id],h6[class|id],blockquote[class],pre[class],code[class],table[class|style],thead,tbody,tfoot,tr[class],td[colspan|rowspan|class|style],th[colspan|rowspan|class|style],iframe[src|width|height|frameborder],section[class|id],article[class|id],header[class|id],footer[class|id],nav[class|id],figure[class],figcaption[class],video[src|controls|width|height],audio[src|controls]',
            'CSS.AllowedProperties' => 'font,font-size,font-weight,font-style,font-family,text-decoration,padding,padding-left,padding-right,padding-top,padding-bottom,color,background-color,background,text-align,margin,margin-left,margin-right,margin-top,margin-bottom,border,border-width,border-color,border-style,display,width,height,max-width,max-height,min-width,min-height,float,clear,vertical-align,overflow,position,left,right,top,bottom,z-index',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => false,
            'HTML.SafeIframe' => true,
            'URI.SafeIframeRegexp' => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/|maps\.google\.com/maps|www\.google\.com/maps/embed|player\.vimeo\.com/video)%',
            'Attr.AllowedFrameTargets' => ['_blank', '_self', '_parent', '_top'],
            'HTML.MaxImgLength' => null,
            'CSS.MaxImgLength' => null,
            'HTML.FlashAllowFullScreen' => false,
            'HTML.SafeObject' => false,
            'HTML.SafeEmbed' => false,
            'URI.AllowedSchemes' => ['http', 'https', 'mailto', 'tel', 'data'],
            'URI.DisableExternalResources' => false,
            'Output.TidyFormat' => false,
            'Attr.EnableID' => true,
            'Attr.AllowedClasses' => true,
        ],
        
        // Service content configuration - for pool service descriptions
        'services' => [
            'HTML.Doctype' => 'HTML 4.01 Transitional',
            'HTML.Allowed' => 'div[class],p[class],br,strong,em,u,b,i,a[href|title|target],ul[class],ol[class],li,h2,h3,h4,h5,h6,span[class],blockquote',
            'CSS.AllowedProperties' => 'color,text-align,font-weight,font-style',
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty' => true,
            'HTML.SafeIframe' => false,
            'URI.AllowedSchemes' => ['http', 'https', 'tel'],
            'Attr.AllowedFrameTargets' => ['_blank'],
            'URI.DisableExternalResources' => true,
            'Attr.AllowedClasses' => 'lead,text-muted,text-center,alert,alert-info,alert-warning,highlight,badge,list-unstyled,feature-list',
        ],
    ],
];