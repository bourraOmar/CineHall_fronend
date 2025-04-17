const modal = document.getElementById('createFilmModal');
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');

        openModalBtn.addEventListener('click', () => {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });

        const closeModal = () => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        };

        closeModalBtn.addEventListener('click', closeModal);
        cancelBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem("token");

    if (!token) {
        window.location.href = "/login";
        return;
    }

    const createFilmForm = document.getElementById("createFilmForm");

    createFilmForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData();
        formData.append("title", document.getElementById("title").value);
        formData.append("genre", document.getElementById("genre").value);
        formData.append("duration", document.getElementById("duration").value);
        formData.append("minimum_age", document.getElementById("minimum_age").value);
        formData.append("trailer_url", document.getElementById("trailer_url").value);
        formData.append("description", document.getElementById("description").value);
        formData.append("image", document.getElementById("image").files[0]);

        fetch('http://localhost:8000/api/film', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            },
            body: formData,
        })
        .then(async res => {
            const json = await res.json();
            let info = document.getElementById('infopara');
            if (res.status === 201) {
                info.innerHTML = "Film created successfuly"
                setTimeout(() => {
                    info.innerHTML = "";
                }, 1000);
                
                closeModal();
                console.log('Success:', json);
            } else {
                console.error('Error:', json);
            }
        })
        .catch(err => console.error('Request failed:', err));
    });
});
