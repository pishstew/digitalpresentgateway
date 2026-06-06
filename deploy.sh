#!/bin/bash
# ============================================================
#  deploy.sh — dijalankan oleh GitHub Actions via SSH
#  Lokasi: /home/kepishing/myserver/website_data/DPG/DPG-main/
# ============================================================
set -e  # hentikan jika ada error

PROJECT_DIR="/home/kepishing/myserver/website_data/DPG/DPG-main"

echo "──────────────────────────────────────"
echo "  SIJA Presensi — Auto Deploy"
echo "  $(date '+%Y-%m-%d %H:%M:%S')"
echo "──────────────────────────────────────"

cd "$PROJECT_DIR"

# ── 1. Pull kode terbaru dari GitHub ──────────────────────────
echo "[1/5] Git pull..."
git pull origin main   # ganti ke "master" jika perlu

# ── 2. Copy .env jika belum ada (jangan overwrite .env live) ──
echo "[2/5] Cek .env..."
if [ ! -f .env ]; then
  cp .env.example .env
  echo "      .env dibuat dari .env.example"
else
  echo "      .env sudah ada, dilewati"
fi

# ── 3. Rebuild image Docker jika Dockerfile berubah ───────────
echo "[3/5] Docker build..."
docker compose build --no-cache app

# ── 4. Restart container tanpa downtime (recreate) ────────────
echo "[4/5] Docker up..."
docker compose up -d --force-recreate app

# ── 5. Jalankan perintah Laravel di dalam container ───────────
echo "[5/5] Laravel post-deploy..."
docker compose exec -T app php artisan migrate --force
docker compose exec -T app php artisan config:cache
docker compose exec -T app php artisan route:cache
docker compose exec -T app php artisan view:cache

echo ""
echo "✓ Deploy selesai!"
echo "──────────────────────────────────────"
