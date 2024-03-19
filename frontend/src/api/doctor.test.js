import { Doctor } from "@/api/doctor";
import { Speciality } from "@/api/speciality";
import { createPinia, setActivePinia } from "pinia";
import { test, expect } from "vitest";

setActivePinia(createPinia());

test('find doctor with id = 1', async () => {
    let doctor = await Doctor.find(1);
    expect(doctor).not.toBeNull();
    expect(doctor).toBeInstanceOf(Doctor);
    expect(doctor.id).toBe(1);
    expect(doctor.fullName.split(' ').length).toBe(2);
    expect(doctor.speciality).toBeInstanceOf(Speciality);
});
