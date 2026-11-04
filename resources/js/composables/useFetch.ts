import { ref, toValue } from 'vue';

export function useFetch<T>(url: string, formValue: T, callback?: Function) {
    const data = ref<data | null>(null);
    const errors = ref<errors | undefined>(undefined);
    const isLoading = ref(false);

    const execute = async () => {
        isLoading.value = true;
        errors.value = undefined;

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(toValue(formValue))
            });

            if (!response.ok) {
                if (response.status === 422) {
                    errors.value = await response.json();
                } else if (response.status === 429) {
                    throw new Error(response.statusText);
                } else {
                    throw new Error('Something went wrong. Try again later.');
                }
            } else {
                data.value = await response.json();
            }
        } catch (e) {
            errors.value = { errors: { system: [e instanceof Error ? e.message : 'Something went wrong.'] } };
        } finally {
            isLoading.value = false;

            if (callback) {
                callback();
            }
        }
    };

    return { data, errors, isLoading, execute };
}
