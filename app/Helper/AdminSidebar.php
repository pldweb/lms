<?php

namespace App\Helper;

class AdminSidebar 
{
    public static function setSidebarMenu(){
        $data = [
                [
                    'text' => 'Dashboard',
                    'icon' => 'ph ph-squares-four',
                    'badge' => '3',
                    'submenu' => [
                        ['text' => 'Dashboard One', 'link' => 'index.html'],
                        ['text' => 'Dashboard Two', 'link' => 'index-2.html'],
                        ['text' => 'Dashboard Three', 'link' => 'index-3.html'],
                    ],
                ],
                [
                    'text' => 'Courses',
                    'icon' => 'ph ph-graduation-cap',
                    'submenu' => [
                        ['text' => 'Student Courses', 'link' => 'student-courses.html'],
                        ['text' => 'Mentor Courses', 'link' => 'mentor-courses.html'],
                        ['text' => 'Create Course', 'link' => 'create-course.html'],
                    ],
                ],
                ['text' => 'Students', 'icon' => 'ph ph-users-three', 'link' => 'students.html'],
                ['text' => 'Assignments', 'icon' => 'ph ph-clipboard-text', 'link' => 'assignment.html'],
                ['text' => 'Mentors', 'icon' => 'ph ph-users', 'link' => 'mentors.html'],
                ['text' => 'Resources', 'icon' => 'ph ph-bookmarks', 'link' => 'resources.html'],
                ['text' => 'Messages', 'icon' => 'ph ph-chats-teardrop', 'link' => 'message.html'],
                ['text' => 'Analytics', 'icon' => 'ph ph-chart-bar', 'link' => 'analytics.html'],
                ['text' => 'Events', 'icon' => 'ph ph-calendar-dots', 'link' => 'event.html'],
                ['text' => 'Library', 'icon' => 'ph ph-books', 'link' => 'library.html'],
                ['text' => 'Pricing', 'icon' => 'ph ph-coins', 'link' => 'pricing-plan.html'],
                ['type' => 'label', 'text' => 'Settings'],
                ['text' => 'Account Settings', 'icon' => 'ph ph-gear', 'link' => 'setting.html'],
                [
                    'text' => 'Authentication',
                    'icon' => 'ph ph-shield-check',
                    'submenu' => [
                        ['text' => 'Sign In', 'link' => 'sign-in.html'],
                        ['text' => 'Sign Up', 'link' => 'sign-up.html'],
                        ['text' => 'Forgot Password', 'link' => 'forgot-password.html'],
                        ['text' => 'Reset Password', 'link' => 'reset-password.html'],
                        ['text' => 'Verify Email', 'link' => 'verify-email.html'],
                        ['text' => 'Two Step Verification', 'link' => 'two-step-verification.html'],
                    ],
                ],
            ];
        return $data;
    }
}