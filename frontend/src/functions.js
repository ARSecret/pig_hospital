export function getDoctorImageUrl(doctor) {
    if (doctor.photoUrl) {
        return doctor.photoUrl;
    }

    return `/default-doctor-${doctor.gender}.jpg`;
}
