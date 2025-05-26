<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { Textarea } from '@/components/ui/textarea'
import type { Post } from '@/types';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ArrowLeftIcon, Pencil, UserCircle2Icon, Trash } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
    post: Post;
    can: {
        update: boolean;
        delete: boolean;
    };
}

const props = defineProps<Props>();

const dialogOpen = ref(false);

const form = useForm({content: ''});

function submitComment() {
    form.post(route('posts.comments.store', { post: props.post.id }), {
        onSuccess: () => {
            form.reset();
            dialogOpen.value = false;
        },
    });
}

function deleteComment(commentId: string) {
    router.delete(route('comments.destroy', {comment: commentId}), {
        onSuccess: () => {
            // Optionally, you can handle UI updates after deletion
        },
    });
}


const formatDate = (dateString: string | null | undefined): string => {
    if (!dateString) return '';
    return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: true,
    });
};
</script>

<template>
    <AppLayout :title="post.title">
        <div class="mx-auto max-w-3xl space-y-4">
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
                            <Link :href="route('posts.edit', post.id)" v-if="can.update" class="text-blue-500 hover:underline">Edit </Link>
                            <Link
                                :href="route('posts.destroy', post.id)"
                                method="delete"
                                as="button"
                                v-if="can.delete"
                                class="text-red-500 hover:underline"
                                >Delete
                            </Link>
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
            <Dialog :open="dialogOpen">
                <DialogTrigger>
                    <Button variant="outline" @click="dialogOpen = true" class="cursor-pointer">
                        <Pencil class="mr-2 h-4 w-4" />
                        Write a Comment
                    </Button>
                </DialogTrigger>
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>New Comment</DialogTitle>
                    </DialogHeader>
                    <form class="space-y-4" @submit.prevent="submitComment">
                        <div class="space-y-1">
                            <Textarea
                                v-model="form.content"
                                placeholder="Write your comment here..."

                                rows="4"
                                required
                            />
                            <small v-if="form.errors.content" class="text-red-500">
                                {{ form.errors.content }}
                            </small>
                        </div>
                        <Button type="submit" :disabled="form.processing" class="w-full">
                            Submit Comment
                        </Button>
                    </form>
                    <Button variant="outline" @click="dialogOpen = false" class="w-full">
                        Cancel
                    </Button>
                </DialogContent>
            </Dialog>
            <div v-if="post.comments && post.comments.length > 0">
                <h2 class="mb-4 text-xl font-semibold">Comments ({{ post.comments.length }})</h2>
                <ul>
                    <li v-for="comment in post.comments" :key="comment.id" class="mb-4">
                        <Card>
                            <CardHeader>
                                <CardTitle class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2">
                                        <UserCircle2Icon class="h-6 w-6" />
                                        {{ comment.user?.name ?? 'Anonymous' }}
                                    </div>
                                    <Button v-if="comment.can_delete" @click="deleteComment(comment.id)" variant="destructive" size="sm" class="cursor-pointer">
                                        <Trash class="h-4 w-4" />
                                        Delete
                                    </Button>
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
            <div v-else class="text-center">No comments yet.</div>
        </div>
    </AppLayout>
</template>
