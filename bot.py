from telegram import Update
from telegram.ext import ApplicationBuilder, CommandHandler, ContextTypes
import os

async def start(update: Update, context: ContextTypes.DEFAULT_TYPE):
    await update.message.reply_text("иди нахуй, бот не работает")

if __name__ == '__main__':
    token = os.getenv("BOT_TOKEN")  # безопасно получаем токен из переменной окружения
    app = ApplicationBuilder().token(token).build()
    app.add_handler(CommandHandler("start", start))
    app.run_polling()
