using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Net.NetworkInformation;
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

namespace zametki
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {
        string currentDirectory = "";
        public MainWindow()
        {
            InitializeComponent();
            initDirectory();
            updateListView();
        }

        private void updateListView()
        {
            lst.ItemsSource = getNotes();
        }

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

        private void NewTxtButton_Click(object sender, RoutedEventArgs e)
        {
            OpenTxtWindow w = new OpenTxtWindow();
            if(w.ShowDialog() == true)
            {
                updateListView();
            }
        }

        private void NewCanvasButton_Click(object sender, RoutedEventArgs e)
        {
            OpenIsfWindow w = new OpenIsfWindow(); 
            if (w.ShowDialog() == true)
            {
                updateListView();

            }
        }

       

        private void lst_PreviewMouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            Note note = lst.SelectedItem as Note;
            if (note == null) return;
            if (note.Type == ".txt")
            {
                OpenTxtWindow w = new OpenTxtWindow(note);
                if (w.ShowDialog() == true)
                {
                    updateListView();

                }
            }
            if (note.Type == ".isf")
            {
                OpenIsfWindow w = new OpenIsfWindow(note);
                if (w.ShowDialog() == true)
                {
                    updateListView();

                }
            }
        }

        private void DeleteButton_Click(object sender, RoutedEventArgs e)
        {
            Note note = lst.SelectedItem as Note;
            if (note == null) return;
            if (File.Exists(note.Path))
            {
                try
                {
                    File.Delete(note.Path);
                    MessageBox.Show("succes");
                    updateListView();
                }
                catch
                {
                    MessageBox.Show("error");
                }
            }
        }
    }
}
