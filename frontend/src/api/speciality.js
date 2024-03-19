import { useApi } from "@/stores/api";

import { NotFoundError } from "./errors";

export class Speciality {
    constructor(id, name, description) {
        this.id = id;
        this.name = name;
        this.description = description;
    }

    static async find(id) {
        let api = useApi();

        let rawSpeciality = await api.getData(`/specialities/${id}`);
        if (rawSpeciality === null) {
            throw new NotFoundError;
        }

        return new Speciality(
            rawSpeciality.id,
            rawSpeciality.name,
            rawSpeciality.description,
        );
    }
};