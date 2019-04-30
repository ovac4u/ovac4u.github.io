import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { MuiThemeProvider, createMuiTheme } from '@material-ui/core/styles';
import './App.css';
import Routes from './routes';
import { blue, indigo } from '@material-ui/core/colors';
import { CssBaseline } from '@material-ui/core';

const theme = createMuiTheme({
	palette: {
		secondary: {
			main: blue[900]
		},
		primary: {
			main: indigo[700]
		}
	},
	typography: {
		// Use the system font instead of the default Roboto font.
		fontFamily: ['"Lato"', 'sans-serif'].join(',')
	}
});

export default class App extends Component {
	render() {
		return (
			<React.Fragment>
				<CssBaseline />

				<MuiThemeProvider theme={theme}>
					<Routes />
				</MuiThemeProvider>
			</React.Fragment>
		);
	}
}
