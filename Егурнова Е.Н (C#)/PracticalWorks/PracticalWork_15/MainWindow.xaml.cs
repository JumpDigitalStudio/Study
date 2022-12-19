using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Diagnostics;
using System.IO;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace PracticalWork_15
{
    /// <summary>
    /// Логика взаимодействия для MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        string currentDirectory = "";



        // Инициализация программы
        public MainWindow()
        {
            InitializeComponent();
            initDirectory();
            updateListView();
        }



        // Методы взаимодействия пользователя с UI элементами
        private void Border_MouseDown(object sender, MouseButtonEventArgs e)
        {
            if (e.ChangedButton == MouseButton.Left)
            {
                this.DragMove();
            }
        }

        private bool IsMaximized = false;
        private void Border_MouseLeftButtonDown(object sender, MouseButtonEventArgs e)
        {
            if (e.ClickCount == 2)
            {
                if (IsMaximized)
                {
                    this.WindowState = WindowState.Normal;
                    this.Width = 700;
                    this.Height = 700;

                    IsMaximized = false;
                }
                else
                {
                    this.WindowState = WindowState.Maximized;

                    IsMaximized = true;
                }
            }
        }



        // Инициализация директории для сохранения
        public void initDirectory()
        {
            string exeDir = AppDomain.CurrentDomain.BaseDirectory;
            string relPath = @"..\data"; // Относительный путь к файлу
            string resPath = System.IO.Path.Combine(exeDir, relPath); // Объединяет две строки в путь.
            currentDirectory = System.IO.Path.GetFullPath(resPath); // Возвращает для указанной строки пути абсолютный путь.

            if (!Directory.Exists(currentDirectory))
            {
                Directory.CreateDirectory(currentDirectory);
            }
        }
        // Обновление списка заметок
        private void updateListView()
        {
            NotesList.ItemsSource = getNotes();
        }
        // Инициализация списка заметок
        private List<Note> getNotes()
        {
            List<Note> notes = new List<Note>();

            string[] allfiles = Directory.GetFiles(currentDirectory);
            foreach (string filePath in allfiles)
            {
                string path = filePath;
                string fileName = System.IO.Path.GetFileName(filePath);
                string date = System.IO.File.GetCreationTime(filePath).ToString();
                string type = fileName.Substring(fileName.LastIndexOf('.'));
                string name = fileName.Substring(0, fileName.LastIndexOf('.'));

                Note note = new Note(name, path, type, date);

                notes.Add(note);
            }

            return notes;
        }



        // Редактирование раннее созданной заметки
        private void NotesList_PreviewMouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            Note note = NotesList.SelectedItem as Note;
            if (note == null) return;
            if (note.Type == ".txt")
            {
                NewTextNote PageNewNote = new NewTextNote(note);
                PageNewNote.Show();
                this.Hide();

                updateListView();
            }
            if (note.Type == ".isf")
            {
                NewDrawNote PageNewDraw = new NewDrawNote(note);
                PageNewDraw.Show();
                this.Hide();

                updateListView();
            }
        }



        // Создать новую текстовую заметку
        private void CreateNewtextNote_Click(object sender, RoutedEventArgs e)
        {
            NewTextNote PageNewNote = new NewTextNote();
            PageNewNote.Show();
            this.Hide();

            updateListView();
        }
        // Создать новый рисунок - заметку
        private void CreateNewDrawNote_Click(object sender, RoutedEventArgs e)
        {
            NewDrawNote PageNewDraw = new NewDrawNote();
            PageNewDraw.Show();
            this.Hide();

            updateListView();
        }



        // Закрыть программу
        private void CloseButton_Click(object sender, RoutedEventArgs e)
        {
            this.Close();
            Process.GetCurrentProcess().Kill();
        }

        private void DeleteNote_Click(object sender, RoutedEventArgs e)
        {
            Note note = NotesList.SelectedItem as Note;
            if (note == null) return;
            if (File.Exists(note.Path))
            {
                try
                {
                    File.Delete(note.Path);
                    updateListView();
                }
                catch
                {
                    MessageBox.Show("Ошибка удаления заметки. Обратитесь в поддержку.", "Внимание");
                }
            }
        }
    }
}
