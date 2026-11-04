import { ref, toValue } from 'vue';

type error = Record<string, string[]>;
type errors = {
    errors: error;
    message?: string;
    version?: string;
};
type data = {
    data: {
        result: string;
        model: string;
        errors: error;
    };
    version: string;
};

export function useFetch<T>(url: string, formValue: T, callback?: Function) {
    const data = ref<data | null>(null);
    const errors = ref<errors | null>(null);
    const isLoading = ref(false);

    const execute = async () => {
        isLoading.value = true;
        errors.value = null;

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
                    const errors = await response.json();
                    console.log(errors);
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
