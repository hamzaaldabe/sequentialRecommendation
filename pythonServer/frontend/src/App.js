import './App.css';
import { useState, useEffect } from 'react';

const App = () => {
  const [data, setData] = useState([]);
  const [newChoiceText, setNewChoiceText] = useState('');
  const [newQuestionText, setNewQuestionText] = useState('');



  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const response = await fetch('http://localhost:8000/polls/questions/');
      const jsonData = await response.json();
      setData(jsonData);
    } catch (error) {
      console.log(error);
    }
  };

  const handleChoiceDelete = async (choiceId) => {
    try {
      const response = await fetch(`http://localhost:8000/polls/choice/delete/${choiceId}/`, {
        method: 'DELETE',
      });

      if (response.ok) {
        // Choice deleted successfully
        fetchData(); // Fetch updated data
      } else {
        // Handle error if needed
        console.log('Error deleting choice');
      }
    } catch (error) {
      console.log(error);
    }
  };


  const handleNewChoiceSubmit = async (event, questionId) => {
    event.preventDefault();

    try {
      const response = await fetch('http://localhost:8000/polls/choice/add/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ question: questionId, choice_text: newChoiceText }),
      });

      if (response.ok) {
        // Choice added successfully
        fetchData(); // Fetch updated data
        setNewChoiceText(''); // Clear the input field
      } else {
        // Handle error if needed
        console.log('Error adding choice');
      }
    } catch (error) {
      console.log(error);
    }
  };

  const handleChoiceIncrement = async (choiceId) => {
    try {
      const response = await fetch('http://localhost:8000/polls/choice/increment/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ choice_id: choiceId }),
      });

      if (response.ok) {
        // Vote incremented successfully
        fetchData(); // Fetch updated data
      } else {
        // Handle error if needed
        console.log('Error incrementing vote');
      }
    } catch (error) {
      console.log(error);
    }
  };


  const handleNewQuestionSubmit = async (event) => {
    event.preventDefault();

    try {
      const response = await fetch('http://localhost:8000/polls/question/add/', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ question_text: newQuestionText }),
      });

      if (response.ok) {
        // Question added successfully
        fetchData(); // Fetch updated data
        setNewQuestionText(''); // Clear the input field
      } else {
        // Handle error if needed
        console.log('Error adding question');
      }
    } catch (error) {
      console.log(error);
    }
  };

  return (
    <div>

    <form onSubmit={handleNewQuestionSubmit}>
        <input
          type="text"
          placeholder="Enter new question"
          value={newQuestionText} onChange={(event) => setNewQuestionText(event.target.value)}
        />
        <button type="submit">Add Question</button>
      </form>

      {data.map(question => (
        <div key={question.id}>
          <h2>{question.question_text}</h2>
          <form onSubmit={(event) => handleNewChoiceSubmit(event, question.id)}>
            <input
              type="text"
              placeholder="Enter new choice"
              value={newChoiceText}
              onChange={(event) => setNewChoiceText(event.target.value)}
            />
            <button type="submit">Add Choice</button>
          </form>

          <ul>
          {question.choices.map(choice => (
              <li key={choice.id}>
                {choice.choice_text} - Votes: {choice.votes}, <button  onClick={() => handleChoiceDelete(choice.id)}>delete</button>
                <button onClick={() => handleChoiceIncrement(choice.id)}>Increment</button>

              </li>
            ))}
          </ul>
        </div>
      ))}
    </div>
  );
}

export default App;

