<?php

namespace App\Enums;

enum NavigationGroup: string
{
    case BlogManagement = 'Blog Management';
    case ContentManagement = 'Content Management';
    case UserManagement = 'User Management';
    case SystemSettings = 'System Settings';
    case ProjectManagement = 'Project Management';
}