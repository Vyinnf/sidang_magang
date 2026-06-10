// public/js/notifications.js

document.addEventListener("DOMContentLoaded", function () {
    // ================= Toast Flash =================
    (function initFlashToast() {
        const toastElement = document.getElementById("crudToast");
        const toastHeader = document.getElementById("toastHeader");
        const toastBody = document.getElementById("toastBody");
        if (typeof bootstrap !== "undefined" && toastElement) {
            const bootstrapToast = new bootstrap.Toast(toastElement, {
                delay: 3000,
            });
            const successMessage = document.body.dataset.successMessage;
            const errorMessage = document.body.dataset.errorMessage;
            const warningMessage = document.body.dataset.warningMessage;
            if (successMessage) {
                toastHeader.textContent = "Sukses!";
                toastElement.classList.remove(
                    "text-bg-danger",
                    "text-bg-warning"
                );
                toastBody.textContent = successMessage;
                bootstrapToast.show();
            } else if (errorMessage) {
                toastHeader.textContent = "Error!";
                toastElement.classList.remove(
                    "text-bg-success",
                    "text-bg-warning"
                );
                toastBody.textContent = errorMessage;
                bootstrapToast.show();
            } else if (warningMessage) {
                toastHeader.textContent = "Peringatan!";
                toastElement.classList.remove(
                    "text-bg-success",
                    "text-bg-danger"
                );
                toastBody.textContent = warningMessage;
                bootstrapToast.show();
            }
        }
    })();

    // ================= Notifications Dropdown =================
    const notifWrapper = document.getElementById("nav-notification-wrapper");
    if (!notifWrapper) return; // Only run on authenticated layout

    const dropdownToggle = document.getElementById("notificationDropdown");
    const markAllBtn = document.getElementById("markAllReadBtn");
    const badgeEl = document.getElementById("notif-badge");
    const listContainer = document.getElementById("notif-list-container");
    const loadingEl = document.getElementById("notif-loading");

    let loaded = false;
    let loading = false;

    async function fetchNotifications() {
        if (loading) return;
        loading = true;
        loadingEl &&
            (loadingEl.classList.remove("d-none"),
            (loadingEl.textContent = "Memuat..."));
        try {
            const res = await fetch("/notifications?limit=10", {
                headers: { Accept: "application/json" },
            });
            if (!res.ok) throw new Error("Gagal memuat notifikasi");
            const data = await res.json();
            renderNotifications(data);
        } catch (e) {
            if (listContainer) {
                listContainer.innerHTML =
                    '<div class="text-danger text-center small py-3">Gagal memuat.</div>';
            }
        } finally {
            loading = false;
            loadingEl && loadingEl.classList.add("d-none");
            loaded = true;
        }
    }

    function renderNotifications(payload) {
        if (!listContainer) return;
        badgeEl &&
            ((badgeEl.textContent = payload.unread_count),
            badgeEl.classList.toggle("bg-danger", payload.unread_count > 0));
        if (!payload.items.length) {
            listContainer.innerHTML =
                '<div class="text-center py-4 small text-muted">Tidak ada notifikasi</div>';
            return;
        }
        const html = payload.items
            .map((item) => {
                const unreadClass = item.is_unread ? "bg-light-subtle" : "";
                const title =
                    item.data?.title ||
                    item.data?.label ||
                    item.type ||
                    "Notifikasi";
                let message = item.data?.message || item.data?.body || "";
                if (!message) {
                    // fallback konstruksi pesan ringkas dari field data jika tersedia
                    if (item.data?.tmt && item.data?.nama) {
                        message = `TMT ${escapeHtml(
                            item.data.tmt
                        )} • ${escapeHtml(item.data.nama)}`;
                    }
                }
                const time = item.time_ago;
                return `<a href="#" data-id="${
                    item.id
                }" class="list-group-item list-group-item-action notif-item ${unreadClass}">
                <div class="d-flex">
                    <div class="flex-shrink-0">
                        <div class="user-avtar bg-light-primary"><i class="ti ti-bell"></i></div>
                    </div>
                    <div class="flex-grow-1 ms-2">
                        <span class="float-end text-muted small">${time}</span>
                        <p class="text-body fw-semibold mb-1" style="font-size:.775rem">${escapeHtml(
                            title
                        )}</p>
                        ${
                            message
                                ? `<span class="text-muted d-block" style="font-size:.7rem">${escapeHtml(
                                      message
                                  )}</span>`
                                : ""
                        }
                    </div>
                </div>
            </a>`;
            })
            .join("");
        listContainer.innerHTML = `<div class="list-group list-group-flush w-100">${html}</div>`;
    }

    function escapeHtml(str) {
        return String(str).replace(
            /[&<>"]+/g,
            (s) =>
                ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;" }[s])
        );
    }

    async function markAllRead() {
        try {
            const res = await fetch("/notifications/mark-all-read", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": getCsrfToken() },
            });
            if (!res.ok) throw new Error();
            badgeEl &&
                ((badgeEl.textContent = "0"),
                badgeEl.classList.remove("bg-danger"),
                badgeEl.classList.add("bg-secondary"));
            if (listContainer) {
                listContainer.innerHTML =
                    '<div class="text-center py-4 small text-muted">Tidak ada notifikasi</div>';
            }
        } catch {}
    }

    async function markSingleRead(id, anchorEl) {
        try {
            const res = await fetch(`/notifications/${id}/mark-read`, {
                method: "POST",
                headers: { "X-CSRF-TOKEN": getCsrfToken() },
            });
            if (!res.ok) throw new Error();
            const parentList = anchorEl.parentElement;
            anchorEl.remove();
            if (parentList && parentList.children.length === 0) {
                listContainer.innerHTML =
                    '<div class="text-center py-4 small text-muted">Tidak ada notifikasi</div>';
            }
            if (badgeEl) {
                let current = parseInt(badgeEl.textContent || "0", 10) || 0;
                current = Math.max(0, current - 1);
                badgeEl.textContent = String(current);
                if (current === 0) {
                    badgeEl.classList.remove("bg-danger");
                    badgeEl.classList.add("bg-secondary");
                }
            }
        } catch {}
    }

    function getCsrfToken() {
        const meta = document.querySelector('meta[name="csrf-token"]');
        return meta
            ? meta.getAttribute("content")
            : window.Laravel?.csrfToken || "";
    }

    // Event: open dropdown -> fetch if not loaded
    if (dropdownToggle) {
        dropdownToggle.addEventListener("click", function () {
            if (!loaded) fetchNotifications();
        });
    }

    // Mark all read button
    markAllBtn?.addEventListener("click", function (e) {
        e.preventDefault();
        markAllRead();
    });

    // Delegate click for individual notification
    document.addEventListener("click", function (e) {
        const a = e.target.closest(".notif-item");
        if (a && a.dataset.id) {
            e.preventDefault();
            if (a.classList.contains("bg-light-subtle")) {
                markSingleRead(a.dataset.id, a);
            }
            // Di sini bisa diarahkan ke halaman detail jika ada link tujuan pada data
        }
    });
});
