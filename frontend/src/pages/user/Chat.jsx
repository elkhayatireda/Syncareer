import React from 'react';
import ChatNav from './ChatNav';
import ContactSideBar from './ContactSideBar';
import ChatContact from './ChatContact';
import ChatBubbleSend from './ChatBubbleSend';
import ChatBubbleReceive from './ChatBubbleReceive';
import { useState, useEffect ,useRef } from 'react';
import { axiosClient } from '../../api/axios';
import { useContext } from "react";
import { authContext } from "../../contexts/AuthWrapper";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';


export default function Chat() {
    const userId = 1;
    const profileImageUrl = `http://localhost:8000/images/${userId}.jpg`;
    const icon1 = `http://localhost:8000/images/other/user.png`;


    const [contacts, setContacts] = useState([]);
    const [conversationId, setConversationId] = useState(1);
    const [messages, setMessages] = useState({});


    const { user } = useContext(authContext);

    const MessageInput = useRef(); 

    const handleSubmit = () =>{
         console.log(MessageInput.current.value)
         axiosClient.post('http://localhost:8000/api/chat/send-message', {
          content: MessageInput.current.value,
          conversationId: conversationId,
      })
          .then(response => {
            console.log(conversationId);
          })
          .catch(error => {
              console.error('Error sending message:', error);
          });
    }
    const [initialized, setInitialized] = useState(false);

    useEffect(() => {
      if (!initialized) {
        window.Echo = new Echo({
          broadcaster: 'pusher',
          key: 'Syncareer_key',
          host: 'http://localhost:6001' ,
          forceTLS: false,
          cluster: 'mt1',
          authEndpoint: 'http://localhost:8000/api/broadcasting/auth',
          auth: {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          },
        });
        setInitialized(true);
     
          const channel = window.Echo.private(`private.${1}`);
          channel.listen('.chat', (event) => {
            console.log(`Received chat message for conversation:`, event);
          });
       
          console.log(`hhhhhhh:`);

      
      }
    }, []); // Empty dependency array means this effect runs only once on mount
    
      
    
     
    
  
    
    return (
      <>
      <div className="flex flex-col h-screen">
        {/* hidden contact sidebar for responsive  */}
        <ContactSideBar ImageUrl={icon1}  profileImageUrl={profileImageUrl} UnreadMsgNumber={200} />
        {/* contact side bar */}
        <div className="hidden lg:flex flex-col absolute top-20 bottom-0 left-0 w-96 z-20 bg-gray-100 ">
          <div className="justify-start flex flex-col px-8 pt-6"> 
            <p className="font-medium text-2xl text-black mb-1">Messages</p>
            <p className="text-sm  text-unread mb-1">4 Unread</p>
          </div>
          <div class="relative px-9 mb-7 mt-3">
              <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  {/* <svg class="w-5 h-5 ml-9 text-gray-300 dark:text-gray-300" ariaHidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                      <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                  </svg> */}
              </div>
              <input type="text"  class="block w-full p-3  ps-10 text-sm placeholder:text-gray300 text-gray-800 border-none  rounded-lg bg-white outline-none   " placeholder="Search "  />
          </div>
          {/* display contacts  */}

          <div className="overflow-y-scroll h-full">
         
              <ChatContact
              profileImageUrl={profileImageUrl}
              sender="mostafa bayi"
              timestamp="5 min"
              message="hey sir"
              unreadCount={5}
            />
              <ChatContact
              profileImageUrl={profileImageUrl}
              sender="mostafa bayi"
              timestamp="5 min"
              message="hey sir hey sirhey sirhey sirhey sirhey sirhey sirhey sirhey sirhey sirhey sir"
              unreadCount={0}
            />
          </div>
        </div>
        {/* User profile navbar */}
        <ChatNav ImageUrl={profileImageUrl} Name="Reda el king" JobTitle="HR @google"/>
  
        {/* Chat messages area */}
        
    <div className="flex-grow overflow-y-auto px-2 pt-20 pb-16 lg:ml-96">
     
    </div>
  
        {/* Input area */}

    <div className="lg:pl-5">
    <div className="mb-6 p-2  border border-gray-300 rounded-xl h-20 mx-5 flex flex-row justify-between items-end pt-3 lg:ml-96">
        <div className="basis-3/5 lg:basis-5/6">
            <textarea
            ref={MessageInput}
            id="large-input"
            placeholder="Type your message here..."
            className="h-full outline-none block w-full p-2 text-gray-700 border-none rounded-lg text-base resize-none ml-3"
            ></textarea>
        </div>
        <div className="flex  justify-center items-end basis-1/6">
            <button
            className="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 mr-2"
            >File</button>
            <button
            onClick={handleSubmit}
            type="button"
            className="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-6 py-2.5"
            >
            Send
            </button>
        </div>
    </div>
    </div>


 </div>
      </>
      
    )
  }


    // const chatMessagesAreaStyles = {
    //   flex: '1',
    //   overflowY: 'auto',
    //   scrollbarWidth: 'none', // For Firefox
    //   'msOverflowStyle': 'none', // For IE 11
    //   '&::webkitScrollbar': {
    //     display: 'none',
    //   },
    // };