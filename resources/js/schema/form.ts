import { z } from 'zod';

export const formSchema = z.object({
    excuse: z.string().trim().min(1, 'The excuse field is required.'),
    tone: z.string().trim().min(1, 'The tone field is required.'),
    language: z.string().trim().min(1, 'The language field is required.')
});

export type FormValues = z.infer<typeof formSchema>;

export function validateForm(values: FormValues): Record<string, string[]> | null {
    const validation = formSchema.safeParse(values);

    if (validation.success) {
        return null;
    }

    const fieldErrors: Record<string, string[]> = {};

    for (const issue of validation.error.issues) {
        const field = issue.path[0];

        if (typeof field === 'string') {
            (fieldErrors[field] ??= []).push(issue.message);
        }
    }

    return fieldErrors;
}
