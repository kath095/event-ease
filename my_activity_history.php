<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/config.php'; ?>

<style>
    .card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        width: 340px;
    }

    .card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .card-content {
        padding: 20px;
        display: flex;
    }

    .event-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .event-card-link:hover {
    transform: translateY(-5px);
    text-decoration: none;
    color: inherit;
    }

    .event-card-link:hover .card {
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
    }

    .event-card-link:visited {
    color: inherit;
    text-decoration: none;
    }

    .event-card-link:focus {
    outline: 2px solid #007bff;
    outline-offset: 2px;
    border-radius: 16px;
    }

    .event-date {
        align-items: flex-start;
        margin-bottom: 10px;
    }

    .event-date .month {
        font-size: 12px;
        color: #888;
        margin-right: 8px;
        color: blue;
    }

    .event-date .day {
        font-size: 28px;
        font-weight: bold;
        margin-right: 16px;
    }

    .event-info {
        width: 100%;
    }

    .event-info h3 {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .event-info p {
        font-size: 14px;
        color: #555;
    }


    @media (max-width: 768px) {
        .card {
            width: 100%;
        }
    }


    .styled-textarea {
        width: 400px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .styled-textarea:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);
        outline: none;
    }
</style>
<main style="margin: 100px 50px; text-align: start;">
    <?php
    $message = isset($_GET['message']) ? $_GET['message'] : '';
    ?>
    <div>
        <h1 style="color: black;">Activity History</h1>
        <h2 style="color: black;">Your Upcoming Event</h2>

        <!-- Menampilkan Badge jika ada pesan -->
        <?php if (!empty($message)): ?>
            <div style="display: inline-block; background-color: #28a745; color: white; padding: 15px 10px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; width: 100%;">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    </div>


    <div style="display: flex; flex-wrap: wrap; gap: 20px; align-items: start;">
           <?php
    try {
        $userId = $_SESSION['id'];
        $stmt = $pdo->prepare("
            SELECT e.*
            FROM events e
            INNER JOIN events_regist er ON er.event_id = e.id
            WHERE er.regist_id = :user_id AND er.status = 'belum'
            ORDER BY e.event_date ASC
        ");
        $stmt->execute(['user_id' => $userId]);

        while ($event = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $date = new DateTime($event['event_date']);
            $day = $date->format('d');
            $month = strtoupper($date->format('M'));
            
            // Define eventTitle properly within the loop
            $eventTitle = htmlspecialchars($event['title']);
            $eventSlug = str_replace(' ', '-', $eventTitle);
    ?>
            <a href="event_details.php?event_title=<?= urlencode($eventSlug) ?>" class="event-card-link">
                <div class="card">
                    <img src="assets/<?= htmlspecialchars($event['photo_event']) ?>" alt="<?= $eventTitle ?>" />
                    <div class="card-content">
                        <div class="event-date">
                            <div class="month"><?= $month ?></div>
                            <div class="day"><?= $day ?></div>
                        </div>
                        <div class="event-info">
                            <h3><?= $eventTitle ?></h3>
                            <p><?= htmlspecialchars($event['description']) ?></p>
                        </div>
                    </div>
                </div>
            </a>
    <?php
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
    }
    ?>
</div>


    <div style="display: flex ;justify-content: center;">
        <button onclick="alert('Implement load more function if needed')" class="load-more">Load More</button>
    </div>

    <h2 style="color: black;">Your Latest Event</h2>

    <?php
    require 'config.php';

    $userId = $_SESSION['id'] ?? 1;

    $stmt = $pdo->prepare("
            SELECT 
                e.*, 
                er.id AS event_regist_id, 
                r.review, 
                r.rating,
                r.id as id_review
            FROM events e
            INNER JOIN events_regist er ON er.event_id = e.id
            LEFT JOIN event_regist_review r ON r.event_regist_id = er.id
            WHERE er.regist_id = :user_id AND er.status = 'selesai'
            GROUP BY e.id
            ORDER BY e.event_date DESC
            LIMIT 5
        ");

    $stmt->execute(['user_id' => $userId]);
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);



    $reviewStmt = $pdo->prepare("
            SELECT event_regist_id FROM event_regist_review
            WHERE event_regist_id IN (
                SELECT id FROM events_regist WHERE regist_id = :user_id
            )
        ");
    $reviewStmt->execute(['user_id' => $userId]);
    $reviewedEventRegistIds = $reviewStmt->fetchAll(PDO::FETCH_COLUMN);
    ?>

    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        <?php foreach ($events as $event):
            $date = new DateTime($event['event_date']);
            $day = $date->format('d');
            $month = strtoupper($date->format('M'));
            $eventRegistId = $event['event_regist_id'];
            $isReviewed = in_array($eventRegistId, $reviewedEventRegistIds);
        ?>
            <div class="card">
                <img src="assets/<?= htmlspecialchars($event['photo_event']) ?>" alt="Event Image" />
                <div class="card-content">
                    <div class="event-date">
                        <div class="month"><?= $month ?></div>
                        <div class="day"><?= $day ?></div>
                    </div>
                    <div class="event-info">
                        <h3><?= htmlspecialchars($event['title']) ?></h3>
                        <p><?= htmlspecialchars($event['description']) ?></p>
                        <p style="color: red; font-weight: bold;">Finished</p>

                        <div style="display: flex; justify-content: flex-end; gap: 10px;">
                            <?php if ($isReviewed): ?>
                                <div style="background-color: #001F3F; display: flex; color: white; padding: 10px; gap: 10px; align-items: center; border-radius: 5px; margin-top: 10px;">
                                    <div class="edit-review-btn"
                                        data-id="<?= htmlspecialchars($event['id_review']) ?>"
                                        data-review="<?= htmlspecialchars($event['review'] ?? '') ?>"
                                        data-rating="<?= htmlspecialchars($event['rating'] ?? 0) ?>"
                                        style="cursor: pointer;">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </div>

                                    <form method="POST" action="delete_review.php" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                        <input type="hidden" name="id" value="<?= $event['id_review'] ?>">
                                        <button type="submit" style="background: none; border: none; cursor: pointer; color:white">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                    <p style="color: white; width: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= $event['review']; ?>
                                    </p>

                                </div>
                            <?php else: ?>
                                <div class="add-review-btn" data-id="<?= $eventRegistId ?>" style="cursor: pointer;">
                                    <i class="fa-solid fa-plus"></i> Add Review
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <div id="review-section" style="display: none;">
            <h3>Add Review</h3>
            <form id="global-review-form" method="POST" action="submit_review.php">
                <input type="hidden" name="id" id="review-event-id">
                <input type="hidden" name="rating" id="rating-value">

                <textarea name="review" rows="5" class="styled-textarea" placeholder="Type here..."></textarea>

                <div id="star-rating" style="margin-top: 10px; font-size: 24px; color: #ccc; cursor: pointer;">
                    <i class="fa-solid fa-star" data-value="1"></i>
                    <i class="fa-solid fa-star" data-value="2"></i>
                    <i class="fa-solid fa-star" data-value="3"></i>
                    <i class="fa-solid fa-star" data-value="4"></i>
                    <i class="fa-solid fa-star" data-value="5"></i>
                </div>

                <div style="margin-top: 15px;">
                    <button type="submit" style="padding: 8px 20px; background-color: #001F3F; color: white; border: none; border-radius: 5px;">Save</button>
                </div>
            </form>
        </div>

        <div id="review-section-edit" style="display: none;">
            <h3>Edit Review</h3>
            <form id="global-review-form-edit" method="POST" action="update_review.php">
                <input type="hidden" name="id" id="review-event-id-edit">
                <input type="hidden" name="rating" id="rating-value-edit">

                <textarea name="review" rows="5" id="review_edit" class="styled-textarea" placeholder="Type here..."></textarea>

                <div id="star-rating-edit" style="margin-top: 10px; font-size: 24px; color: #ccc; cursor: pointer;">
                    <i class="fa-solid fa-star" data-value="1"></i>
                    <i class="fa-solid fa-star" data-value="2"></i>
                    <i class="fa-solid fa-star" data-value="3"></i>
                    <i class="fa-solid fa-star" data-value="4"></i>
                    <i class="fa-solid fa-star" data-value="5"></i>
                </div>

                <div style="margin-top: 15px;">
                    <button type="submit" style="padding: 8px 20px; background-color: #001F3F; color: white; border: none; border-radius: 5px;">Save</button>
                </div>
            </form>
        </div>
    </div>



    </div>
</main>



<script>
    document.querySelectorAll('.add-review-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const eventRegistId = btn.getAttribute('data-id');
            document.getElementById('review-event-id').value = eventRegistId;
            document.getElementById('review-section').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('review-section').offsetTop,
                behavior: 'smooth'
            });
        });
    });

    document.querySelectorAll('.edit-review-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const eventRegistId = btn.getAttribute('data-id');
            const review = btn.getAttribute('data-review');
            const rating = btn.getAttribute('data-rating');

            document.getElementById('review-section-edit').style.display = 'block';
            window.scrollTo({
                top: document.getElementById('review-section-edit').offsetTop,
                behavior: 'smooth'
            });
            updateForm(eventRegistId, rating, review);
        });
    });


    function updateForm(id, rating, review) {
        document.getElementById('review-event-id-edit').value = id;
        document.getElementById('rating-value-edit').value = rating;

        document.getElementById('review_edit').value = review;

        const stars = document.querySelectorAll('#star-rating-edit i');
        stars.forEach(star => {
            star.style.color = '#ccc';
        });

        // Warnai bintang sesuai rating
        for (let i = 0; i < rating; i++) {
            stars[i].style.color = '#f39c12';
        }

        const reviewSection = document.getElementById('review-section-edit');
        reviewSection.style.display = 'block';

        reviewSection.scrollIntoView({
            behavior: 'smooth'
        });

        const form = document.getElementById('global-review-form-edit');
        form.setAttribute('action', 'update_review.php');
    }
</script>
<script>
    const stars = document.querySelectorAll('#star-rating i');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const rating = parseInt(star.getAttribute('data-value'));
            ratingInput.value = rating;

            stars.forEach(s => {
                s.style.color = '#ccc';
            });

            for (let i = 0; i < rating; i++) {
                stars[i].style.color = '#f39c12'; // warna emas
            }
        });
    });
</script>

<script>
    // Ambil semua bintang (star) yang ada di elemen dengan ID "star-rating-edit"
    const starsEdit = document.querySelectorAll('#star-rating-edit i');
    const ratingInputEdit = document.getElementById('rating-value-edit');

    starsEdit.forEach(star => {
        star.addEventListener('click', () => {
            // Ambil nilai rating yang disimpan pada atribut data-value
            const rating = parseInt(star.getAttribute('data-value'));

            // Set nilai rating pada input hidden atau input yang sesuai
            ratingInputEdit.value = rating;

            // Reset semua bintang ke warna abu-abu (belum dipilih)
            starsEdit.forEach(s => {
                s.style.color = '#ccc'; // Warna abu-abu
            });

            // Gambar bintang yang dipilih dengan warna emas
            for (let i = 0; i < rating; i++) {
                starsEdit[i].style.color = '#f39c12'; // Warna emas
            }
        });
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>