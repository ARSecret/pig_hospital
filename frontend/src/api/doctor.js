import { useApi } from "@/stores/api";

import { ApiObject } from "./api-object";
import { Speciality } from "./speciality";
import { NotFoundError } from "./errors";


export class Doctor extends ApiObject {
    constructor(
        id,
        fullName,
        specialityId,
    ) {
        super();
        this.id = id;
        this.fullName = fullName;
        this.addLazyProperty('speciality', async () => await Speciality.find(specialityId));
    }

    static async find(id) {
        let api = useApi();

        let rawDoctor = await api.getData(`/doctors/${id}`);
        if (rawDoctor === null) {
            throw new NotFoundError;
        }

        return new Doctor(
            rawDoctor.id,
            rawDoctor.full_name,
            rawDoctor.speciality.id,
        );
    }

    get patients() {
        return [];
    }
};