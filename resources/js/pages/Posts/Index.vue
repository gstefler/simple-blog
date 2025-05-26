<script setup lang="ts">
import type { PaginationData, Post } from '@/types';
import { Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { UserCircle2Icon, MessageSquareIcon, ArrowRightIcon } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';

interface Props {
    posts: PaginationData<Post>
}

defineProps<Props>()

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
        <ul class="max-w-3xl mx-auto">
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
                            <span class="text-gray-500" v-if="post.edited">
                                (edited)
                            </span>
                        </CardDescription>
                    </CardHeader>
                    <CardContent>
                        <h2 class="text-lg font-semibold">{{ post.title }}</h2>
                        <p>{{ truncateContent(post.content) }}</p>
                    </CardContent>
                    <CardFooter>
                        <Link :href="route('posts.show', post.id)" class="text-rose-500 hover:underline flex items-center group">
                            <MessageSquareIcon class="inline h-4 w-4 mr-1" />
                            Read more
                            <ArrowRightIcon class="inline h-4 w-4 ml-2 mt-0.5 opacity-0 group-hover:opacity-100 group-hover:-translate-x-1 transition-all duration-200" />
                        </Link>
                    </CardFooter>
                </Card>
            </li>
        </ul>
    </AppLayout>
</template>

<style scoped>
/* You can add any component-specific styles here if needed, though Tailwind should cover most cases. */
</style>
