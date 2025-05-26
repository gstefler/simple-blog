import type { PageProps } from '@inertiajs/core';
import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    created_at: string;
    updated_at: string;
}

export interface Post {
    id: string;
    title: string;
    content: string;
    edited: boolean;
    user_id: string;
    user?: User;
    comments?: Comment[];
    created_at: string;
    updated_at: string;
}

export interface Comment {
    id: string;
    content: string;
    post_id: string;
    user_id: string;
    user?: User;
    post?: Post;
    created_at: string;
    updated_at: string;
}

export interface PaginationData<T> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    links: {
        url: string | null;
        label: string;
        active: boolean;
    }[];
}

export type BreadcrumbItemType = BreadcrumbItem;
