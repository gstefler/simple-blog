<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Post } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ArrowLeftIcon, UserCircle2Icon } from 'lucide-vue-next';

interface Props {
    post: Post;
    can: {
        update: boolean;
        delete: boolean;
    };
}

defineProps<Props>();

const formatDate = (dateString: string | null | undefined): string => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout :title="post.title">
        <div class="mx-auto max-w-3xl">
            <Link :href="route('posts.index')" class="group mb-4 flex items-center text-rose-500 hover:underline">
                <ArrowLeftIcon class="mr-2 inline h-4 w-4" />
                Back to Posts
            </Link>
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <UserCircle2Icon class="h-6 w-6" />
                            {{ post.user?.name ?? 'Unknown User' }}
                        </div>
                        <div v-if="can.update || can.delete" class="flex items-center gap-2">
                            <Link :href="route('posts.edit', post.id)" v-if="can.update" class="text-blue-500 hover:underline">Edit</Link>
                            <Link :href="route('posts.destroy', post.id)" method="delete" as="button" v-if="can.delete" class="text-red-500 hover:underline">Delete</Link>
                        </div>
                    </CardTitle>
                    <CardDescription class="text-sm">
                        {{ formatDate(post.created_at) }}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <h1 class="mb-4 text-2xl font-bold">{{ post.title }}</h1>
                    <p class="whitespace-pre-line">{{ post.content }}</p>
                </CardContent>
            </Card>
            <div v-if="post.comments && post.comments.length > 0">
                <h2 class="mt-6 mb-4 text-xl font-semibold">Comments ({{ post.comments.length }})</h2>
                <ul>
                    <li v-for="comment in post.comments" :key="comment.id" class="mb-4">
                        <Card>
                            <CardHeader>
                                <CardTitle class="flex items-center gap-2">
                                    <UserCircle2Icon class="h-6 w-6" />
                                    {{ comment.user?.name ?? 'Anonymous' }}
                                </CardTitle>
                                <CardDescription class="text-sm">
                                    {{ formatDate(comment.created_at) }}
                                </CardDescription>
                            </CardHeader>
                            <CardContent>
                                <p class="whitespace-pre-line">{{ comment.content }}</p>
                            </CardContent>
                        </Card>
                    </li>
                </ul>
            </div>
            <div v-else class="mt-4 text-center text-gray-500">No comments yet.</div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* You can add any component-specific styles here if needed, though Tailwind should cover most cases. */
</style>
