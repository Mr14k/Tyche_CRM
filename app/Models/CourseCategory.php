<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use App\Core\TenantContext;

class CourseCategory extends Model
{
    protected string $table = 'course_categories';

    public function getCategoriesForActiveTenant(): array
    {
        $categories = $this->all();
        if (!empty($categories)) {
            return $categories;
        }

        // Auto-seed default academic categories for new tenant if empty
        $tid = TenantContext::getTenantId();
        $defaultCategories = [
            ['name' => 'Digital Marketing & Growth', 'slug' => 'digital-marketing', 'description' => 'SEO, Paid Media, Social Media, and Performance Marketing', 'icon_class' => 'bi-graph-up-arrow'],
            ['name' => 'Data Science & Analytics', 'slug' => 'data-science', 'description' => 'Machine Learning, Python, Big Data, and Business Intelligence', 'icon_class' => 'bi-bar-chart-fill'],
            ['name' => 'Software Development & IT', 'slug' => 'software-dev', 'description' => 'Full-Stack Development, Cloud Architecture, and DevOps', 'icon_class' => 'bi-code-slash'],
            ['name' => 'Business & Management', 'slug' => 'business-management', 'description' => 'Executive Leadership, Product Management, and Finance', 'icon_class' => 'bi-briefcase-fill'],
            ['name' => 'General Certification', 'slug' => 'general-certification', 'description' => 'Foundational and Professional Skill Certification Courses', 'icon_class' => 'bi-award-fill']
        ];

        foreach ($defaultCategories as $cat) {
            $cat['tenant_id'] = $tid;
            $this->create($cat);
        }

        return $this->all();
    }
}
