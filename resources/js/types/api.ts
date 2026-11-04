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
