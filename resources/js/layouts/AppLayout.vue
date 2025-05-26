<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { User } from '@/types';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { SquarePen } from 'lucide-vue-next';
import { Avatar, AvatarFallback } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button';

interface Props {
    title?: string;
}

defineProps<Props>()

const page = usePage()

const user = computed<User | null>(() => (page.props as any).auth.user as User | null);
</script>

<template>
    <header class="">
        <div class="max-w-7xl mx-auto px-4 py-6 flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ title || 'App Layout' }}</h1>
            <div v-if="user" class="space-x-4 items-center flex">
                <Button variant="outline" as-child size="sm">
                    <Link :href="route('posts.create')" class="font-medium">
                        <SquarePen class="mr-2" />
                        Write a Post
                    </Link>
                </Button>
                <DropdownMenu >
                    <DropdownMenuTrigger>
                        <Avatar class="cursor-pointer">
                            <AvatarFallback>
                                {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                            </AvatarFallback>
                        </Avatar>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent>
                        <DropdownMenuItem>
                            {{user.name}}
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            {{user.email}}
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Link :href="route('logout')" as="button" method="post" class="font-medium">
                                Logout
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>

            <Button as-child v-else class="cursor-pointer">
                <Link :href="route('login')" as="button"  class="font-medium">
                    Login
                </Link>
            </Button>
        </div>
    </header>
    <main class="max-w-7xl mx-auto px-4 py-8">
        <slot />
    </main>
</template>

<style scoped>

</style>
