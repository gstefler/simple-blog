<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import type { PaginationData, Post } from '@/types';
import { Link, router } from '@inertiajs/vue3';
import { useDebounce } from '@vueuse/core';
import { ArrowLeftIcon, ArrowRightIcon, MessageSquareIcon, UserCircle2Icon } from 'lucide-vue-next';
import { ref, watch } from 'vue';
import { Button } from '@/components/ui/button';

interface Props {
    posts: PaginationData<Post>;
    filters: { search: string };
}

const props = defineProps<Props>();

const search = ref<string>(props.filters.search || '');
const debouncedSearch = useDebounce(search, 500);

watch(debouncedSearch, (newVal: any, oldVal: any) => {
    if (newVal !== oldVal) {
        router.get(
            route('posts.index', {
                search: newVal,
                page: 1,
            }),
            {},
            {
                preserveState: true,
                preserveScroll: true,
            },
        );
    }
});

const formatDate = (dateString: string | null | undefined): string => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const truncateContent = (content: string | null | undefined, maxLength: number = 150): string => {
    if (!content) return '';
    if (content.length <= maxLength) return content;
    return content.substring(0, maxLength) + '...';
};
</script>

<template>
    <AppLayout title="Posts">
        <div class="mx-auto my-6 max-w-3xl">
            <Label for="search">Search Posts</Label>
            <div class="relative mt-1">
                <Input id="search" v-model="search" placeholder="Search by title or content" class="pr-10" />
            </div>
        </div>
        <ul class="mx-auto max-w-3xl">
            <li v-for="post in posts.data" :key="post.id" class="mb-6">
                <Card>
                    <CardHeader>
                        <CardTitle class="flex items-center gap-2">
                            <UserCircle2Icon class="h-6 w-6" />
                            {{ post.user?.name ?? 'Unknown User' }}
                        </CardTitle>
                        <CardDescription class="text-sm">
                            <span>
                                {{ formatDate(post.created_at) }}
                            </span>
                            <span class="text-gray-500" v-if="post.edited"> (edited) </span>
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <h2 class="text-lg font-semibold">{{ post.title }}</h2>
                        <p>{{ truncateContent(post.content) }}</p>
                    </CardContent>
                    <CardFooter>
                        <Link :href="route('posts.show', post.id)" class="group flex items-center text-rose-500 hover:underline">
                            <MessageSquareIcon class="mr-1 inline h-4 w-4" />
                            Read more
                            <ArrowRightIcon
                                class="mt-0.5 ml-2 inline h-4 w-4 opacity-0 transition-all duration-200 group-hover:-translate-x-1 group-hover:opacity-100"
                            />
                        </Link>
                    </CardFooter>
                </Card>
            </li>
        </ul>
        <div class="mt-6 flex justify-center space-x-2">
            <Button v-if="posts.prev_page_url" variant="outline" as-child>
                <Link  :href="posts.prev_page_url">
                    <ArrowLeftIcon class="h-6 w-6" />
                </Link>
            </Button>
            <Button v-if="posts.next_page_url" variant="outline" as-child>
                <Link :href="posts.next_page_url">
                    <ArrowRightIcon class="h-6 w-6" />
                </Link>
            </Button>
        </div>
    </AppLayout>
</template>
