<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';

interface Props {
    post: {
        id: number;
        title: string;
        content: string;
    };
}

const props = defineProps<Props>();

const form = useForm({
    title: props.post.title,
    content: props.post.content,
});

function submit() {
    form.put(route('posts.update', {post: props.post.id}));
}
</script>

<template>
    <AppLayout title="Edit Post">
        <form @submit.prevent="submit" class="space-y-6">
            <div class="max-w-3xl mx-auto space-y-6">
                <div>
                    <Label for="title" class="block text-sm font-medium ">Title</Label>
                    <Input id="title" v-model="form.title" class="mt-1" />
                    <small v-if="form.errors.title" class="text-red-500 text-sm">{{ form.errors.title }}</small>
                </div>
                <div>
                    <Label for="content" class="block text-sm font-medium ">Content</Label>
                    <Textarea id="content" v-model="form.content" class="mt-1 h-48" />
                    <small v-if="form.errors.content" class="text-red-500 text-sm">{{ form.errors.content }}</small>
                </div>
                <Button type="submit" class="w-full">
                    Submit Changes
                </Button>
            </div>
        </form>
    </AppLayout>
</template>

<style scoped>

</style>
