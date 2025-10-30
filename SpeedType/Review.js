document.addEventListener('DOMContentLoaded', function() {
    const reactionButtons = document.querySelectorAll('.reaction-btn');

    reactionButtons.forEach(button => {
        button.addEventListener('click', async function() {
            const reviewId = this.dataset.reviewId;
            const reactionType = this.dataset.type;

            try {
                const response = await fetch('handle_reaction.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `review_id=${reviewId}&reaction_type=${reactionType}`
                });

                const data = await response.json();

                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred while processing your reaction');
            }
        });
    });
});