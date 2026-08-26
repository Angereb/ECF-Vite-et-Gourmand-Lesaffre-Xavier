document.querySelectorAll('.toast').forEach(toast => {
    setTimeout(() => {
        toast.remove();
    }, 4000);
});